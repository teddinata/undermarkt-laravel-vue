<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Transaction;

use App\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = User::count();
        $revenue = Transaction::where('transaction_status', 'SUCCESS')->sum('total_price');

        $all_transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])->paginate(5);
        $transaction = Transaction::count();
        return view('pages.admin.dashboard', [
            'customer'=> $customer,
            'revenue' => $revenue,
            'transaction' => $transaction,
            'all_transaction' => $all_transaction
        ]);
    }
}
