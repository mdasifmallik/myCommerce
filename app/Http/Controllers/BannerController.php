<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Carbon\Carbon;
use Image;

class BannerController extends Controller
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
        return view('admin.banner.index', [
            'banners' => Banner::all()
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
    public function store(Request $request)
    {
        $request->validate([
            'banner_title' => 'required',
            'banner_content' => 'required',
            'banner_photo' => 'image'
        ]);

        $banner_id = Banner::insertGetId($request->except('_token') + [
            'created_at' => Carbon::now()
        ]);

        if ($request->hasFile('banner_photo')) {
            $photo = $request->file('banner_photo');
            $photo_name = $banner_id . "." . $photo->getClientOriginalExtension();
            $photo_location = 'public/uploads/banner_photos/' . $photo_name;
            Image::make($photo)->fit(1920, 1080)->save(base_path($photo_location));

            Banner::findOrFail($banner_id)->update([
                'banner_photo' => $photo_name
            ]);
        }

        return back()->with('success_status', 'Banner added successfully!');
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
    public function edit(Banner $banner)
    {
        return view('admin.banner.edit', [
            'banner' => $banner
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'banner_title' => 'required',
            'banner_content' => 'required',
            'banner_photo' => 'image'
        ]);

        $banner->update($request->except('_token', '_method', 'banner_photo'));

        if ($request->hasFile('banner_photo')) {
            if ($banner->banner_photo != 'default.jpg') {
                unlink(base_path('public/uploads/banner_photos/' . $banner->banner_photo));
            }
            $photo = $request->file('banner_photo');
            $photo_name = $banner->id . "." . $photo->getClientOriginalExtension();
            $photo_location = 'public/uploads/banner_photos/' . $photo_name;
            Image::make($photo)->fit(1920, 1080)->save(base_path($photo_location));

            Banner::findOrFail($banner->id)->update([
                'banner_photo' => $photo_name
            ]);
        }

        return back()->with('success_status', 'Banner edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        return back()->with('delete_status', 'Banner deleted successfully!');
    }
}
