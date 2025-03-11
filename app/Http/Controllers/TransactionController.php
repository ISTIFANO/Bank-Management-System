<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    public function CreateTransaction(Request $request)
    {


        $request->validate(["amount" => "required", "description" => "required", "name" => "required", "email" => "required"]);
        $sender_id = Auth::user()->id();
$sender = User::find($sender_id);
        $sender_wallet =  Wallet::find($sender_id);

if(!($sender_wallet->balance <= $request["amount"])){


    return response()->json(["message" => "budjet not found"]);
}


        $user = User::where((['email' => $request["email"]]));
        if (!$user) {

            return response()->json(["message" => "user not found"]);
        }

        $wallet =  Wallet::find($user->id);
        $budjet = $request['amount'] + $wallet->balance;
        Wallet::update(['balance' => $budjet]);

      
        return response()->json(["reciever" => $user, "sender" => $sender, "amount" => $request['amount']]);
    }
}
