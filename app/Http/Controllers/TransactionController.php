<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function CreateTransaction(Request $request)
    {


        $request->validate(["amount" => "required", "description" => "required", "sender_email" => "required", "receiver_email" => "required"]);
        $sender = User::where(["email"=>$request['receiver_email']]);
$sender_id= $sender->id;
$sender_wallet= Wallet::where(["user_id"=>$sender_id]);

$reciever = User::where(["email"=>$request['receiver_email']]);
$reciever_id= $reciever->id;
$reciever_wallet= Wallet::where(["user_id"=>$reciever_id]);

if(!($sender_wallet->balance <= $request["amount"])){


    return response()->json(["message" => "budjet not found"]);
}
DB::beginTransaction();
try{

        $budjet = $sender_wallet->balance - $request['amount'];
        Wallet::update(['balance' => $budjet]);


        $budjet = $reciever_wallet->balance + $request['amount'];
        Wallet::update(['balance' => $budjet]);



      Db::commit();
    
    }catch(Exception $e){

Db::rollBack();

      }
        return response()->json(["reciever" => $reciever, "sender" => $sender, "amount" => $request['amount']]);
    }
}
