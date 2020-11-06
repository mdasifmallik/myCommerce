<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Frontend Controller Routes
Route::get('/', 'FrontendController@index');
Route::get('/about', 'FrontendController@about');
Route::get('/contact', 'FrontendController@contact')->name('frontend_contact');
Route::get('/product/details/{slug}', 'FrontendController@productdetails')->name('product_details');
Route::get('/blog/posts', 'FrontendController@blog_posts')->name('blog_posts');
Route::get('/post/details/{id}', 'FrontendController@post_details')->name('post_details');
Route::post('/post/comment/{id}', 'FrontendController@post_comment')->name('post_comment');
Route::get('/shop/shop_page/{id}', 'FrontendController@shop_page')->name('shop_page');
Route::get('/customer/register', 'FrontendController@customerregister')->name('customerregister')->middleware('guest');
Route::post('/customer/register/post', 'FrontendController@customerregisterpost')->name('customerregisterpost');
Route::post('/review/post', 'FrontendController@review_post')->name('review_post');
Route::post('/search/products', 'FrontendController@search_products')->name('search_products');
Route::resource('newsletter_subscriber', 'NewsletterSubscriberController');


//Home Controller Routes
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/send/newsletter', 'HomeController@sendnewsletter');

//Category Controller Routes
Route::get('/add/category', 'CategoryController@addcategory');
Route::post('/add/category/post', 'CategoryController@addcategorypost');
Route::get('/delete/category/{category_id}', 'CategoryController@deletecategory');
Route::get('/edit/category/{category_id}', 'CategoryController@editcategory');
Route::post('/edit/category/post', 'CategoryController@editcategorypost');
Route::get('/restore/category/{category_id}', 'CategoryController@restorecategory');
Route::get('/force_delete/category/{category_id}', 'CategoryController@forceDeletecategory');
Route::post('mark/delete', 'CategoryController@markdelete');

//Profile Controller Routes
Route::get('profile', 'ProfileController@profile');
Route::post('edit/profile/post', 'ProfileController@editprofilepost');
Route::post('edit/password/post', 'ProfileController@editpasswordpost');
Route::post('change/profile/photo', 'ProfileController@changeprofilephoto');


//Product Controller Routes
Route::resource('product', 'ProductController');


//Product Controller Routes
Route::resource('order', 'OrderController');


//Testimonail Controller Routes
Route::resource('testimonial', 'TestimonialController');


//Banner Controller Routes
Route::resource('banner', 'BannerController');


//Message Controller Routes
Route::resource('message', 'MessageController');
Route::get('message/restore/{id}', 'MessageController@restoremessage')->name('restoremessage');
Route::get('message/delete/{id}', 'MessageController@deletemessage')->name('deletemessage');
Route::get('message/download/{id}', 'MessageController@downloadmessage')->name('downloadmessage');


//FAQ Controller Routes
Route::resource('faq', 'FaqController');


//Blog Controller Routes
Route::resource('blog', 'BlogController');


//Cart Controller Routes
Route::post('/add/cart/{id}', 'CartController@add_cart')->name('add_cart');
Route::post('/add/cart/ajax/{id}', 'CartController@add_cart_ajax')->name('add_cart_ajax');
Route::get('/cart_main', 'CartController@cart_index')->name('cart.index');
Route::get('/cart_main/{coupon_name}', 'CartController@cart_index');
Route::get('/cart/remove/{id}', 'CartController@cart_remove')->name('cart.remove');
Route::post('/cart/update', 'CartController@update_cart')->name('update_cart');


//Coupon Controller Routes
Route::resource('coupon', 'CouponController');


//Customer Controller Routes
Route::get('customer/home', 'CustomerController@customer_home')->name('customer_home');
Route::get('customer/invoice/download/{id}', 'CustomerController@customerinvoicedownload');


//Checkout Controller Routes
Route::get('checkout/index', 'CheckoutController@index')->name('checkout');
Route::post('checkout/post', 'CheckoutController@post_checkout')->name('post_checkout');
Route::post('/get/city/list/ajax', 'CheckoutController@getcitylistajax');
Route::get('/test/mail', 'CheckoutController@testMail');


//Contactinfo Controller Routes
Route::get('contact/info', 'ContactinfoController@index')->name('contactinfo');
Route::post('contact/info/update', 'ContactinfoController@update_contactinfo')->name('update_contactinfo');




Auth::routes(['verify' => true]);

Route::get('register', function () {
    return redirect('/customer/register');
});


//Github Repository Controller
Route::get('login/github', 'GithubController@redirectToProvider');
Route::get('login/github/callback', 'GithubController@handleProviderCallback');


//Stripe Controller
Route::get('stripe', 'StripePaymentController@stripe')->name('stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
