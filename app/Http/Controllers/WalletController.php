<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{




    public function createWallet(Request $request){
        $request->validate(["number" => "required", "user_id" => "required","balance" => "required"]);

        $request['number']=parent::RandomNb();

      $response =  Wallet::Create(['number'=>$request['number'],'user_id'=>$request['user_id'],'balance'=>$request['balance']]);


        return response()->json($response,201);
        }

public function delete(Request $request){
    $request->validate(["delete_id" => "required"]);

  $wallet =  Wallet::find($request["delete_id"]);

$wallet->delete();

return response()->json(['message'=>'deleted']);

}
public function updateBalance(Request $request){
    $request->validate(["delete_id" => "required"]);

  $wallet =  Wallet::find($request["delete_id"]);

$wallet->delete();

return response()->json(['message'=>'deleted']);

}





}
