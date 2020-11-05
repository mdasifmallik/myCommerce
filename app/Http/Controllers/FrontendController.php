<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Product;
use App\Testimonial;
use App\Banner;
use App\Faq;
use App\Blog;
use App\Order_detail;
use App\User;
use App\Post_comment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cache\RedisTaggedCache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use NumberFormatter;

class FrontendController extends Controller
{

    public function index()
    {
        $best_sellers = DB::table('order_details')
            ->select('product_id', DB::raw('count(*) as total'))
            ->groupBy('product_id')->get();

        $best_sellers_after_desc = $best_sellers->sortByDesc('total')->take(4);

        return view('frontend.index', [
            'categories' => Category::all(),
            'products' => Product::latest()->limit(16)->get(),
            'testimonials' => Testimonial::all(),
            'banners' => Banner::all(),
            'best_sellers_after_desc' => $best_sellers_after_desc
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function productdetails($slug)
    {
        $product_info = Product::where('slug', $slug)->firstOrFail();
        $related_products = $product_info->category->products;
        $order_detail_id = null;

        if ($order_details = Auth::user()->order_details->where('product_id', $product_info->id)->whereNull('review')) {
            foreach ($order_details as $order_detail) {
                if ($order_detail->order->payment_status == 2) {
                    $order_detail_id = $order_detail->id;
                }
            }
        }

        $reviews = Order_detail::where('product_id', $product_info->id)->whereNotNull('review')->get();

        return view('frontend.productdetails', [
            'product_info' => $product_info,
            'related_products' => $related_products->where('id', '!=', $product_info->id)->take(4),
            'faqs' => Faq::all(),
            'order_detail_id' => $order_detail_id,
            'reviews' => $reviews
        ]);
    }

    public function blog_posts()
    {
        return view('frontend.blog', [
            'blog_posts' => Blog::paginate(9)
        ]);
    }

    public function post_details($id)
    {
        return view('frontend.single_blog', [
            'all_posts' => Blog::where('id', '!=', $id)->latest()->limit(4)->get(),
            'categories' => Category::all(),
            'blog_post' => Blog::findOrFail($id),
            'next_blog_post_id' => Blog::where('id', '>', $id)->min('id')
        ]);
    }

    public function post_comment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required'
        ]);

        Post_comment::insert($request->except('_token', 'blog_id') + [
            'blog_id' => $id,
            'created_at' => Carbon::now()
        ]);

        return redirect(url()->previous() . '#comment_section');
    }

    public function shop_page($id)
    {
        return view('frontend.shop', [
            'all_products' => Product::all(),
            'categories' => Category::all(),
            'selected_category' => $id
        ]);
    }

    public function customerregister()
    {
        return view('frontend.register');
    }

    public function customerregisterpost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 2,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now()
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return Redirect('/customer/home');
        }

        return back();
    }

    public function review_post(Request $request)
    {
        $order_detail = Order_detail::findOrFail($request->order_detail_id);
        $order_detail->update([
            'review' => $request->message,
            'stars' => $request->stars
        ]);

        $order_detail->product->reviews = $order_detail->product->reviews + 1;
        $order_detail->product->stars = $order_detail->product->stars + $request->stars;
        $order_detail->product->save();

        return back();
    }

    public function search_products(Request $request)
    {
        $request->validate([
            'search_text' => 'required'
        ]);
        $id = "all";

        return view('frontend.shop', [
            'all_products' => Product::where('product_name', 'LIKE', '%' . $request->search_text . '%')->get(),
            'categories' => Category::all(),
            'selected_category' => $id
        ]);
    }
}
