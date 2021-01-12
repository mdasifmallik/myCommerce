<?php

namespace App\Http\Controllers;

use App\Billing;
use App\Cart;
use App\City;
use App\Country;
use App\Mail\PurchaseConfirm;
use App\Order;
use App\Order_detail;
use App\Product;
use App\Shipping;
use Carbon\Carbon;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $generated_cart_id = Cookie::get('g_cart_id');
        if ($generated_cart_id) {
            if (!Cart::where('generated_cart_id', $generated_cart_id)->exists()) {
                return back()->with('error_msg', 'Cart is empty!');
            }
        } else {
            return back()->with('error_msg', 'Cart is empty!');
        }

        return view('frontend.checkout', [
            'countries' => Country::all()
        ]);
    }

    public function post_checkout(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'address' => 'required'
        ]);


        if (isset($request->shipping_address_status)) {
            $request->validate([
                's_name' => 'required',
                's_email' => 'required',
                's_phone_number' => 'required',
                's_country_id' => 'required',
                's_city_id' => 'required',
                's_address' => 'required'
            ]);

            $shipping_id = Shipping::insertGetId([
                'name' => $request->s_name,
                'email' => $request->s_email,
                'phone_number' => $request->s_phone_number,
                'country_id' => $request->s_country_id,
                'city_id' => $request->s_city_id,
                'address' => $request->s_address,
                'created_at' => Carbon::now()
            ]);
        } else {
            $shipping_id = Shipping::insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'created_at' => Carbon::now()
            ]);
        }

        $billing_id = Billing::insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
            'notes' => $request->notes,
            'created_at' => Carbon::now()
        ]);

        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'sub_total' => session('sub_total'),
            'discount_amount' => session('discount_amount'),
            'coupon_name' => session('coupon_name'),
            'total' => (session('sub_total') - session('discount_amount')),
            'payment_option' => $request->payment_option,
            'billing_id' => $billing_id,
            'shipping_id' => $shipping_id,
            'created_at' => Carbon::now()
        ]);

        foreach (cart_items() as $cart_item) {
            Order_detail::insert([
                'order_id' => $order_id,
                'user_id' => Auth::id(),
                'product_id' => $cart_item->product_id,
                'product_quantity' => $cart_item->product_quantity,
                'product_price' => $cart_item->product->product_price,
                'created_at' => Carbon::now()
            ]);
            Product::findOrFail($cart_item->product_id)->decrement('product_quantity', $cart_item->product_quantity);
            $cart_item->forceDelete();
        }

        $order = Order::findOrFail($order_id);
        $order_details = Order_detail::where('order_id', $order_id)->get();

        Mail::to($request->email)->send(new PurchaseConfirm($order, $order_details));

        if ($request->payment_option == 2) {
            session(['order_id_from_checkout_page' => $order_id]);
            return redirect('/stripe');
        } else {
            Session::flash('success', 'Product bought successfull!');
            return redirect('/cart_main');
        }
    }

    public function getcitylistajax(Request $request)
    {
        $string = "";
        $cities = City::where('country_id', $request->country_id)->get();
        foreach ($cities as $city) {
            $string .= "<option value='" . $city->id . "'>" . $city->name . "</option>";
        }

        echo $string;
    }

    public function testMail()
    {
        $order_details = Order_detail::where('order_id', 1)->get();
        return (new PurchaseConfirm($order_details))->render();
    }
}
