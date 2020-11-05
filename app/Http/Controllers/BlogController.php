<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Blog;
use Carbon\Carbon;
use Auth;
use Image;

class BlogController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog.index', [
            'blog_posts' => Blog::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'blog_title' => 'required',
            'blog_content' => 'required'
        ]);

        $blog_id = Blog::insertGetId($request->except('_token', 'blog_banner') + [
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'created_at' => Carbon::now()
        ]);

        if ($request->hasFile('blog_banner')) {
            $photo = $request->file('blog_banner');
            $photo_name = $blog_id . "." . $photo->getClientOriginalExtension();
            $photo_location = 'public/uploads/blog_photos/' . $photo_name;
            Image::make($photo)->fit(870, 500)->save(base_path($photo_location));

            Blog::findOrFail($blog_id)->update([
                'blog_banner' => $photo_name
            ]);
        }

        return back()->with('success_status', 'New Post published successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return back();
    }
}
