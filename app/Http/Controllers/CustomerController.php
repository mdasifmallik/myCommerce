<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CustomerController extends Controller
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

    public function customer_home()
    {
        return view('customer.customer_home', [
            'orders' => Order::with('order_details')->where('user_id', Auth::id())->get()
        ]);
    }

    public function customerinvoicedownload($id)
    {
        $order_info = Order::findOrFail($id);

        $pdf = PDF::loadView('pdf.invoice', compact('order_info'));
        return $pdf->download('invoice.pdf');
    }
}
