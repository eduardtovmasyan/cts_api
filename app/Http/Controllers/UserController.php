<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserR;
use Hash;
use Validator;

class UserController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$validation = Validator::make(
    	$request->all(),
    	[
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'phone' => 'nullable|numeric|unique:users,phone',
    		'password' => 'required|min:6',
    	]);

    	if ($validation->fails()) {

    	return response()->json(['errors' => $validation->errors()]);
    	} else {
    	$user = $request->all();
    	$user['type'] = 'admin';
    	User::create($user);
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	return User::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$validation = Validator::make(
    	$request->all(),
    	[
    		'name' => 'required',
    		'email' => 'required|email',
    		'phone' => 'nullable|numeric',
    		'password' => 'required|min:6',
    	]);
    	
    	$validation->after(function($validation) use($request){
    	$mail = User::where('email', $request->email)->first();
		$phone = User::where('phone', $request->phone)->first();

    	if($phone['id'] == $request->id) {
    		$validation->errors()->add('phone','The phone has already been taken.');
    	}

    	if ($mail['id'] == $request->id) {
    		$validation->errors()->add('email','The email has already been taken.');
    	}
        });

    	if ($validation->fails()) {

    	return response()->json(['errors' => $validation->errors()]);
    	} else {
    	User::whereId($id)->update($request->all());
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$user = User::find($id);
    	$user->delete();
    }
}
