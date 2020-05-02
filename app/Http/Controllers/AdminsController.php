<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Validator;

class AdminsController extends Controller
{

    function NewAdmin (Request $r)
    {
    	$validation=Validator::make($r->all(),
    	[
    		"name"=>"required",
    		"surname"=>"required",
    		"email"=>"required|email|unique:users,email",
    		"phone"=>"nullable|numeric",
    		"password"=>"required|min:6",
    		"config_password"=>"required|same:password",
    		"is_active"=>"required|integer",
    	]);

    	if ($validation->fails()) 
    	{

    	return json_encode("Validation Error");

    	} else {

    	$user = new User();
    	$user->name = $r->name;
    	$user->surname = $r->surname;
    	$user->email = $r->email;
    	$user->phone = $r->phone;
    	$user->phone = $r->phone;
    	$user->type = 'admin';
    	$user->is_active = $r->is_active;
    	$user->password = Hash::make($r->password);
    	$user->save();

    	return json_encode("Success");

    	}
    }

    function ShowAdmin(Request $r)
	{

        $data = User::where('id', $r->id)->first();

        return $data;

	}

	function DeleteAdmin(Request $r)
	{

		User::where('id',$r->id)->delete();

	}

	function UpdateAdmin(Request $r)
	{
		$validation=Validator::make($r->all(),
    	[
    		"name"=>"required",
    		"surname"=>"required",
    		"email"=>"required|email|unique:users,email",
    		"phone"=>"nullable|numeric",
    		"is_active"=>"required|integer",
    	]);

    	if ($validation->fails()) 
    	{

    	return json_encode("Validation Error");

    	} else {

    	User::where('id', $r->id)->update(
    	[
    		'name' => $r->name,
    		'surname' => $r->surname,
    		'email' => $r->email,
    		'phone' => $r->phone,
    		'is_active' => $r->is_active
    	]);

    	return json_encode("Success");

    	}
	}

	function AllAdmins (Request $r)
	{

        $data = User::all();

        return $data;

	}
}
