<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){


        $request->validate(["email"=>"required","password"=>"required"]);

// $response=["email"=>$request["email"],"password"=>$request["password"]];

$user = User::where("email",$request["email"])->first();


if(!$user || ! Hash::check($request["password"],$user->password)){

    return response()->json(["message"=>"Not woking"]);

}

$token = $user->createToken("bank-app")->plainTextToken();

$response=["user"=>$user,"token"=>$token];


return response()->json($response,201);
        
    }

    public function logout(){
auth()->user()->tokens()->delete();

$response =["message"=>"is logout"];

return response()->json($response);

    }


}
