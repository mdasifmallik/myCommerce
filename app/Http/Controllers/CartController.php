<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Cart;
use App\Coupon;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CartController extends Controller
{
    public function cart_index($coupon_name = "")
    {
        $error_msg = "";
        $discount_perc = 0;
        $subtotal = 0;
        foreach (cart_items() as $item) {
            $subtotal += $item->product->product_price * $item->product_quantity;
        }

        $coupon = Coupon::where('coupon_name', $coupon_name)->first();

        if (!$coupon && $coupon_name) {
            $error_msg = "There is no such coupon!";
        } else if ($coupon && $coupon_name) {
            if ($coupon->validity_till <= Carbon::now()) {
                $error_msg = "This coupon isn't valid anymore!";
            } elseif ($coupon->minimum_purchase_amount > $subtotal) {
                $error_msg = "You should purchase more than " . $coupon->minimum_purchase_amount . "/- to activate this coupon!";
            } else {
                $discount_perc = $coupon->discount_amount;
                session(['discount_perc' => $coupon->discount_amount]);
            }
        }

        $valid_coupons = Coupon::whereDate('validity_till', '>=', Carbon::now())->get();

        return view('frontend.cart', [
            'error_msg' => $error_msg,
            'discount_perc' => $discount_perc,
            'coupon_name' => $coupon_name,
            'valid_coupons' => $valid_coupons
        ]);
    }

    public function add_cart(Request $request, $id)
    {
        if (Cart::latest()->first()) {
            $key = Cart::latest()->first()->id + 1;
        } else {
            $key = 1;
        }

        if (Cookie::get('g_cart_id')) {
            $generated_cart_id = Cookie::get('g_cart_id');
        } else {
            $generated_cart_id = Str::random(5) . $key;
            Cookie::queue('g_cart_id', $generated_cart_id, 1440);
        }

        if (Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $id)->exists()) {
            Cart::where('generated_cart_id', $generated_cart_id)->where('product_id', $id)->increment('product_quantity', $request->product_quantity);
        } else {
            Cart::insert([
                'generated_cart_id' => $generated_cart_id,
                'product_id' => $id,
                'product_quantity' => $request->product_quantity,
                'created_at' => Carbon::now()
            ]);
        }

        return back();
    }


    public function cart_remove($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->route('cart.index');
    }


    public function update_cart(Request $request)
    {
        // return $request->product_info;
        // die();
        foreach ($request->product_info as $cart_id => $product_quantity) {
            Cart::findOrFail($cart_id)->update([
                'product_quantity' => $product_quantity
            ]);
        }

        return redirect()->route('cart.index');
    }
}
