<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryForm;

use App\Category;
use App\Product;
use Auth;
use Image;
use Carbon\Carbon;


class CategoryController extends Controller
{
    public function addcategory()
    {
    	return view('admin.category.index',[
            'categories' => Category::all(),
            'deleted_categories' => Category::onlyTrashed()->get()
        ]);
    }

    public function addcategorypost(CategoryForm $request)
    {
    	$category_id = Category::insertGetId([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
            'user_id' => Auth::id(),
            'created_at' => Carbon::now()
        ]);

        if ($request->hasFile('category_photo')) {
            $upload_photo = $request->file('category_photo');
            $new_photo_name = $category_id.".".$upload_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/category_photos/'.$new_photo_name;
            Image::make($upload_photo)->fit(250,250)->save(base_path($new_photo_location));

            Category::find($category_id)->update([
                'category_photo' => $new_photo_name,
            ]);
        }

        return back()->with('success_status', $request->category_name.' category added successfully!!');
    }

    public function deletecategory($category_id)
    {
        Category::find($category_id)->delete();

        return back()->with('delete_status','Category deleted successfully!!');
    }

    public function editcategory($category_id)
    {
        return view('admin.category.edit', [
            'category_info' => Category::find($category_id)
        ]);
    }

    public function editcategorypost(Request $request)
    {
        $request->validate([
            'category_name' => 'unique:categories,category_name,'.$request->category_id,
            'category_description' => 'required',
            'category_photo' => 'image'
        ]);

        Category::find($request->category_id)->update([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description
        ]);

        if ($request->hasFile('category_photo')) {
            $old_photo = Category::findOrFail($request->category_id)->category_photo;
            if ($old_photo != 'default.png') {
                $old_photo_location = 'public/uploads/category_photos/'.$old_photo;
                unlink(base_path($old_photo_location));
            }

            $upload_photo = $request->file('category_photo');
            $new_photo_name = $request->category_id.".".$upload_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/category_photos/'.$new_photo_name;
            Image::make($upload_photo)->fit(250,250)->save(base_path($new_photo_location));

            Category::find($request->category_id)->update([
                'category_photo' => $new_photo_name,
            ]);
        }

        // return back()->with('edit_status','Category edited successfully!!');
        return redirect('add/category')->with('edit_status','Category edited successfully!!');
    }

    public function restorecategory($category_id)
    {
        Category::withTrashed()->find($category_id)->restore();
        return back()->with('restore_status','Category restored successfully!');
    }

    public function forceDeletecategory($category_id)
    {
        if (Category::withTrashed()->findOrFail($category_id)->category_photo != 'default.png') {
            $old_photo_location = 'public/uploads/category_photos/'.Category::withTrashed()->findOrFail($category_id)->category_photo;
            unlink(base_path($old_photo_location));
        }

        Product::where('category_id',$category_id)->delete();

        Category::withTrashed()->findOrFail($category_id)->forceDelete();

        return back()->with('forceDelete_status','Category deleted permanently!!');
    }

    public function markdelete(Request $request)
    {
        $request->validate([
            'category_id' => 'required'
        ]);

        foreach ($request->category_id as $cat_id) {
            Category::findOrFail($cat_id)->delete();
        }

        return back();
    }
}
