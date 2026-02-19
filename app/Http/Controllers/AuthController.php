<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\Models\User;


class AuthController extends Controller
{


public function register(Request $request){

    try{
   $validated = $request -> validate(['email'=>'required | email | unique:users','password'=>'required | min:6']);

    /* CREATE USER  */
    $user = User::create(['email'=>$validated['email'],'password'=>Hash::make($validated['password'])]);



    /* CREATE TOKEN FOR USER  */

    $token = $user->createToken('auth_token')->plainTextToken;


    /* RETURN JSON FORMAATED DAT WITH USER AND TOKEN  */

    return response()->json(['user'=>$user,'token'=>$token]);

    }catch(\Exception $ie){

        return response()->json(['message'=>'Something went wrong','error'=>$ie->getMessage()],500);

}


}


public function login(Request $request) {

$credentials = $request->validate(['email'=>'required|email','password'=>'required']);

//
if(!Auth::attempt($credentials)){

    return response()->json(['message'=>'invalid credentials'],401);


}

$user = Auth::user();

$token = $user->createToken('auth_token')->plainTextToken;

return response()->json(['user'=>$user,'token'=>$token]);




}


public function logout(Request $request){

$request->user()->currentAccessToken()->delete();

return response()->json(['message'=>'Logged out','result'=>201]);


}




}
