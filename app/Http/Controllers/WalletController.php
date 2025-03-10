<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{




    public function createWallet(Request $request){
    
        $request['number']=parent::RandomNb();

      $response =  Wallet::Create(['number'=>$request['number'],'user_id'=>$request['user_id'],'balance'=>$request['balance']]);


        return response()->json($response,201);
        }







}
