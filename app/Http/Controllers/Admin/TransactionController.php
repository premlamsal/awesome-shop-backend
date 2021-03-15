<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\Http\Resources\Transaction as TransactionResource;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::with('user.details')->paginate(8);

        return TransactionResource::collection($transaction);
    }
    public function show($id)
    {
        $transaction = Transaction::where('id', $id)->with('user.details')->get();

        return TransactionResource::collection($transaction);
    }
    public function status(Request $request)
    {
        $transaction = Transaction::findOrFail($request->transaction_id);
        $user = User::findOrFail($request->user_id);


        if ($request->status == 'approved') {
            $transaction->status = 'approved';
            if ($transaction->amount <= $user->balance) {
                if ($transaction->save()) {

                    $user->balance = $user->balance - $transaction->amount;
                    if ($user->save()) {
                        return response(['message' => 'Transaction changed to approved', 'status' => 'success']);
                    } else {
                        return response(['message' => 'Error Updating user data status', 'status' => 'error']);
                    }
                } else {
                    return response(['message' => 'Error Updating trasaction status', 'status' => 'error']);
                }
            } else {
                return response(['message' => 'User (' . $user->firstname . ' ' . $user->lastname . ') don\'t have enough balance', 'status' => 'error']);
            }
        } else if ($request->status == 'cancel') {
            $transaction->status = 'canceled';
            if ($transaction->save()) {
                return response(['message' => 'Transaction changed to ' . $request->status . '', 'status' => 'success']);
            }
        } else {
            return response(['message' => 'Error Updating trasaction status', 'status' => 'error']);
        }
    }
}
