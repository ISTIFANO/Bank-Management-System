<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Exception;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function CreateTransaction(Request $request)

    {

        $validator = Validator::make($request->all(),[
            "amount" => "required|numeric",
            "description" => "required|string",
            "receiver" => "required|email",
        ]);
       if($validator->fails()){
            return response()->json([
                "message" => $validator->errors(),
            ]);
       }
        $sender_id =Auth::user()->id;

            // return response()->json(["user" =>$user]) ;
    

        $sender_wallet = DB::table("wallets")->where("user_id", "=",$sender_id)->first();
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



            $transaction = Transaction::create([
                'amount' => $request->amount,
                'description' => $request->description,
                'date' => now(),
                'receiver_id' => $receiver->id,
                'sender_id' => $sender_id,
                'status' => 'active'
            ]);
            
            DB::commit();

            return response()->json(["transaction" =>  $transaction]);


        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => "Transaction not working", "error" => $e->getMessage()]);
        }
    }


    public function delete(Request $request){
        $request->validate(["delete_id" => "required"]);
    
      $transaction =  Transaction::find($request["delete_id"]);
    
    $transaction->delete();
    
    return response()->json(['message'=>'deleted']);
    
    }

    
public function updatestatus(Request $request){
   
 DB::table('transactions')
            ->where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);

return response()->json(['message'=>'status updated']);

}

}
