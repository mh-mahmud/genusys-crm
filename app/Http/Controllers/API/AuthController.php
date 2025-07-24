<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
		//var_dump($request);die();
    	$inputs = $request->validate([
    		'first_name' => 'required|string',
    		'last_name' => 'required|string',
    		'email' => 'required|string|unique:users,email',
    		'password' => 'required|string|confirmed'
    	]);

    	$user = User::create([
    		'first_name' => $inputs['first_name'],
    		'last_name' => $inputs['last_name'],
    		'email' => $inputs['email'],
    		'password' => bcrypt($inputs['password'])
    	]);
    	$token = $user->createToken('gpleCRMToken')->plainTextToken;

    	$response = [
    		'user' => $user,
    		'token' => $token
    	];
    	return response($response, 201);
    }

    public function logout(Request $request) {
    	auth()->user()->tokens()->delete();
    	return [
    		'message' => 'Logged Out'
    	];
    }
 
    public function login(Request $request) {
    	$inputs = $request->validate([
    		'email' => 'required|string',
    		'password' => 'required|string'
    	]);

    	$user = User::where('email', $inputs['email'])->first();
    	// check password
    	if(!$user || !Hash::check($inputs['password'], $user->password)) {
    		return response(['message' => 'Bad credetials'], 401);
    	}
    	$token = $user->createToken('gpleCRMToken')->plainTextToken;

    	$response = [
    		'user' => $user,
    		'token' => $token
    	];
    	return response($response, 201);
    }
}
