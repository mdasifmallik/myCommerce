<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Mail;
use App\Mail\Newsletter;
use App\Newsletter_subscriber;
use App\Order;
use Carbon\Carbon;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_role');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $users = User::all();
        // $users = User::orderBy('id','desc')->get();

        $months = [];
        $sales = [];
        $currentMonth = Carbon::now()->month;

        for ($i = 0; $i < 6; $i++) {
            if ($currentMonth < 1) {
                break;
            }
            $months[$i] = DateTime::createFromFormat('!m', $currentMonth)->format('F');
            $sales[$i] = Order::where('payment_status', 2)->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', $currentMonth)->sum('orders.total');
            $currentMonth--;
        }

        $users = User::latest()->paginate(3);
        $num_of_users = Newsletter_subscriber::count();

        $paid = Order::where('payment_status', 2)->count();
        $unpaid = Order::where('payment_status', 1)->count();
        $canceled = Order::where('payment_status', 3)->count();

        return view('home', compact('users', 'num_of_users', 'paid', 'unpaid', 'canceled', 'months', 'sales'));
    }

    public function sendnewsletter()
    {
        foreach (Newsletter_subscriber::all()->pluck('email') as $email) {
            Mail::to($email)->queue(new Newsletter);
        }

        return back();
    }
}
