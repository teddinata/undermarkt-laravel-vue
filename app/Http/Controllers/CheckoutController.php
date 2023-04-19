<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Cart;
use App\Transaction;
use App\TransactionDetail;

use Exception;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Save user data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // Proses Checkout
        $code = 'STORE-' . mt_rand(000,999);
        $cart = Cart::with(['product', 'user'])
                ->where('users_id', Auth::user()->id)
                ->get();

        //Transaction Create
        $transaction  = Transaction::create([
            'users_id' =>Auth::user()->id,
            'insurance_price' =>  $request->total_price * 0.2,
            'shipping_price' => 10000,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code
        ]);

        foreach ($cart as $cart) {
            $trx =  'TRX-' . mt_rand(000,999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => 'PENDING',
                'code' => $trx
            ]);
            # code...
        }

        //Delete cart Data
        Cart::where('users_id', Auth::user()->id)->delete();

        // Konfigurasi Midtrans
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('services.midtrans.isProduction');
        // Set sanitization on (default)
        Config::$isSanitized = config('services.midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('services.midtrans.is3ds');

        //Buat array untuk dikirim ke midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'gopay', 'permata_va', 'indomaret', 'bri_va', 'bank_transfer'
            ],
            'vtweb' => []
        ];

            try {
                // Get Snap Payment Page URL
                $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

                // Redirect to Snap Payment Page
               return redirect ($paymentUrl);
            }
            catch (Exception $e) {
                echo $e->getMessage();
            }

    }

    public function callback (Request $request)
    {
        //Set Konfigurasi Midtrans
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

        //Instance midtrans notif

            $notification = new Notification();

        //Assign ke variable untuk memudahkan coding

            $status = $notification->transaction_status;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status;
            $order_id = $notification->order_id;

        //Cari transaksi berdasarkan ID

            $transaction = Transaction::findOrFail($order_id);

        //Handle Notification Status

            if($status == 'capture') {
                if($type == 'credit_card') {
                    if($fraud == 'challenge') {
                        $transaction->status = 'PENDING';
                    }
                    else {
                        $transaction->status = 'SUCCESS';
                    }
                }
            }

            else if($status == 'settlement') {
                $transaction->status = 'SUCCESS';
            }

            else if($status == 'pending') {
                $transaction->status = 'PENDING';
            }

            else if($status == 'deny') {
                $transaction->status = 'CANCELLED';
            }

            else if($status == 'expire') {
                $transaction->status = 'EXPIRED';
            }

            else if($status == 'cancel') {
                $transaction->status = 'CANCELLED';
            }

        //Simpan transaksi

        $transaction->save();
    }
}

