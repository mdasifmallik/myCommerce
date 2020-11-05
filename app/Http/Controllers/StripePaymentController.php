<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        if (!session('order_id_from_checkout_page')) {
            return redirect('cart_main');
        }

        return view('frontend.stripe', [
            'order' => Order::findOrFail(session('order_id_from_checkout_page'))
        ]);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $order = Order::findOrFail(session('order_id_from_checkout_page'));
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([
            "amount" => $order->sub_total * 100,
            "currency" => "bdt",
            "source" => $request->stripeToken,
            "description" => "Payment From Ironman, Order ID: " . $order->id
        ]);

        $order->payment_status = 2;
        $order->save();
        $request->session()->forget('order_id_from_checkout_page');

        Session::flash('success', 'Payment successful!');

        return redirect('cart_main');
    }
}
