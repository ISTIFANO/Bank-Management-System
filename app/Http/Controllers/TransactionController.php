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
        $request->validate([
            "amount" => "required|numeric",
            "description" => "required|string",
            "receiver" => "required|email",
            "seender" => "required|email"
        ]);

        $sender = User::where("email", '=', $request->sender_email)->first();
        if (!$sender) {
            return response()->json(["message" => "Sender not found"]);
        }

        $sender_wallet = DB::table("wallets")->where("user_id", "=", $sender->id)->first();
        if (!$sender_wallet) {
            return response()->json(["message" => "Sender's wallet not found"]);
        }

        $receiver = User::where('email', '=', $request['receiver'])->first();
        if (!$receiver) {
            return response()->json(["message" => "not found"]);
        }

        $receiver_wallet = DB::table("wallets")->where("user_id", "=", $receiver->id)->first();
        if (!$receiver_wallet) {
            return response()->json(["message" => "wallet not found"]);
        }

        DB::beginTransaction();

        try {
       
            $sender_new_balance = $sender_wallet->balance - $request['amount'];
            if ($sender_new_balance < 0) {
                return response()->json(["message" => "Insufficient funds"], 400);
            }

            
            Wallet::where('user_id', $sender_wallet->user_id)->update(['balance' => $sender_new_balance]);

            $receiver_new_balance = $receiver_wallet->balance + $request['amount'];

            Wallet::where('user_id', $receiver_wallet->user_id)->update(['balance' => $receiver_new_balance]);

            DB::commit();

            return response()->json([
                "receiver" => $receiver,
                "sender" => $sender,
                "amount" => $request['amount'],
                "sender_balance" => $sender_new_balance,
                "receiver_balance" => $receiver_new_balance
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Transaction not working", "error" => $e->getMessage()]);
        }
    }
}
