<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function finish()
    {
        $transaction = Transaction::find(request('order_id'));
        $transaction_status = request('transaction_status');
        $title = $transaction_status;

        return view('transactions.finish' , compact(
            'title',
            'transaction',
            'transaction_status',
        ));
    }
}
