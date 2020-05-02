<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Validator;

class UserController extends Controller
{

    function newAdmin (Request $request)
    {
    	$validation = Validator::make(
    	$request->all(),
    	[
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'phone' => 'nullable|numeric|unique:users,phone',
    		'password' => 'required|min:6',
    		'is_active' => 'required|integer',
    	]);

    	if ($validation->fails()) {

    	return json_encode('Validation Error');
    	} else {
    	$user = new User();
    	$user->name = $request->name;
    	$user->surname = $request->surname;
    	$user->email = $request->email;
    	$user->phone = $request->phone;
    	$user->phone = $request->phone;
    	$user->type = 'admin';
    	$user->is_active = $request->is_active;
    	$user->password = Hash::make($request->password);
    	$user->save();

    	return json_encode('Success');
    	}
    }

    function showAdmin(Request $request)
	{
        $data = User::where('id', $request->id)->first();

        return $data;
	}

	function deleteAdmin(Request $request)
	{
		User::where('id',$request->id)->delete();
	}

	function updateAdmin(Request $request)
	{
		$validation = Validator::make($request->all(),
    	[
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'phone' => 'nullable|numeric|unique:users,phone',
    		'is_active' => 'required|integer',
    	]);

    	if ($validation->fails()) {

    	return json_encode('Validation Error');
    	} else {
    	User::where('id', $request->id)->update([
    		'name' => $request->name,
    		'email' => $request->email,
    		'phone' => $request->phone,
    		'is_active' => $request->is_active
    	]);

    	return json_encode('Success');
    	}
	}

	function allAdmins (Request $request)
	{
    	$data = User::all();

    	return $data;
	}
}
