<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\ProductForm;
use App\Category;
use App\Product;
use App\Product_image;
use Carbon\Carbon;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index',[
            "active_categories" => Category::all(),
            "products" => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductForm $request)
    {
        $product_id = Product::insertGetId($request->except('_token','product_thumbnail_photo','product_multiple_photo') + [
            'created_at' => Carbon::now(),
            'slug' => Str::slug($request->product_name."-".Str::random(5))
        ]);

        if($request->hasFile('product_thumbnail_photo')){
            $photo = $request->file('product_thumbnail_photo');
            $photo_name = $product_id.".".$photo->getClientOriginalExtension();
            $photo_location = 'public/uploads/product_photos/'.$photo_name;
            Image::make($photo)->fit(600,622)->save(base_path($photo_location));

            Product::findOrFail($product_id)->update([
                'product_thumbnail_photo' => $photo_name
            ]);
        }

        if($request->hasFile('product_multiple_photo')){
            $flag = 1;
            foreach($request->file('product_multiple_photo') as $single_photo){
                $photo_name = $product_id."-".$flag++.".".$single_photo->getClientOriginalExtension();
                $photo_location = 'public/uploads/product_photos/'.$photo_name;
                Image::make($single_photo)->fit(600,622)->save(base_path($photo_location));

                Product_image::insert([
                    'product_id' => $product_id,
                    'image_name' => $photo_name
                ]);
            }
        }

        return back()->with('success_status','New Product added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.product.show',[
            "active_categories" => Category::all(),
            "product" => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductForm $request,Product $product)
    {
        $product->update($request->except('_token','_method'));
        return back()->with('success_status','Product edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        // foreach ($product->product_images as $product_image) {
        //     $product_image->delete();
        // }
        return back();
    }
}
