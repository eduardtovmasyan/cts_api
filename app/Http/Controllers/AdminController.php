<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\Admin as AdminResources;
use Hash;
use Validator;

class AdminController extends Controller
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
    	return User::where('type',User::TYPE)->get();
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
    		'isActive' => 'required|boolean',
    	]);

    	if ($validation->fails()) {
    	return response()->json(['errors' => $validation->errors()]);
    	} else {
    	$admin = new User();
    	$admin->name = $request->name;
    	$admin->email = $request->email;
    	$admin->phone = $request->phone;
    	$admin->is_active = $request->isActive;
    	$admin->updated_at = now();
    	$admin->created_at = now();
    	$admin->type = User::TYPE;
    	$admin->password = Hash::make($request->password);
    	$admin->save();
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
    	return User::where('type', User::TYPE)->findOrFail($id);
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
    		'email' => 'required|email|unique:users,email,' . $id,
    		'phone' => 'nullable|numeric',
    		'password' => 'required|min:6',
    		'isActive' => 'required|boolean',
    	]);
    	
    	if ($validation->fails()) {
    	return response()->json(['errors' => $validation->errors()]);
    	} else {
    	User::where('type', User::TYPE)->whereId($id)->update($request->all());
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
    	$admin = User::where('type',User::TYPE)->find($id)->delete();
    }
}
