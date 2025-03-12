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

        // dd($request->all());

    //   $formvalidation =  $request->validate(["amount" => "required", "description" => "required", "receiver" => "required", "sender_email" => "required"]);


    //   if(!$formvalidation)   {
    //   return response()->json(["message" => "budjet not found"]);
    // }

    // dd($request["receiver"]);
    // return response()->json([
    //     'descrip' =>$request->description 
    // ]);

        $sender = User::where("email" , '=' , $request->seender)->first();
    //       return response()->json([
    //     'descrip' =>$request->description,
    //     "data"=> $sender->id
    // ]);
        $sender_id = $sender->id;


        $sender_wallet = DB::table("wallets")->where("user_id", "=", $sender_id)->first();

        $receiver = User::where('email', '=', $request['receiver'])->first();
        $reciever_id = $receiver->id;
        // return [ 'sender_wallet ' => $receiver];

        $reciever_wallet = DB::table("wallets")->where("user_id", "=", $reciever_id)->first();
        //    return [ 'sender_wallet ' => $reciever_wallet];

        DB::beginTransaction();
        try {
  
$budjet1 = $sender_wallet->balance - $request['amount'];

Wallet::where('user_id', $sender_wallet->user_id)->update(['balance' => $budjet1]);

$budjet = $reciever_wallet->balance + $request['amount'];
Wallet::where('user_id', $reciever_wallet->user_id)->update(['balance' => $budjet]);



            Db::commit();
        } catch (Exception $e) {
            // return [ 'ilyass ' => $budjet];

            Db::rollBack();
        }
        return response()->json(["reciever" => $receiver, "sender" => $sender, "amount" => $request['amount'],"budjet_sender"=>$budjet1,"budjet_reciever"=>$budjet]);
    }
}
