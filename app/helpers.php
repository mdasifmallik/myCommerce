<?php

function numberofproducts()
{
    return App\Product::count();
}


function cart_count()
{
    return App\Cart::where('generated_cart_id', Cookie::get('g_cart_id'))->count();
}

function cart_items()
{
    return App\Cart::where('generated_cart_id', Cookie::get('g_cart_id'))->get();
}

function contact_info()
{
    return App\Contactinfo::findOrFail(1);
}

function get_categories(){
    return App\Category::all();
}
