<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Testimonial;
use Carbon\Carbon;
use Image;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.testimonial.index',[
            'testimonials' => Testimonial::all()
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
            'client_photo' => "image",
            'client_name' => "required",
            'client_about' => "required",
            'client_message' => "required",
        ]);

        $testimonial_id = Testimonial::insertGetId($request->except('_token') + [
            'created_at' => Carbon::now()
        ]);

        if($request->hasFile('client_photo')){
            $photo = $request->file('client_photo');
            $photo_name = $testimonial_id.".".$photo->getClientOriginalExtension();
            $photo_location = 'public/uploads/testimonial_photos/'.$photo_name;
            Image::make($photo)->fit(250,250)->save(base_path($photo_location));

            Testimonial::findOrFail($testimonial_id)->update([
                'client_photo' => $photo_name
            ]);
        }

        return back()->with('success_status','Testimonial added successfully!');
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
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.edit',[
            'testimonial' => $testimonial
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        // print_r($testimonial);
        // die();
        $request->validate([
            'client_photo' => "image",
            'client_name' => "required",
            'client_about' => "required",
            'client_message' => "required",
        ]);

        $testimonial->update($request->except('_token', '_method', 'client_photo'));

        if($request->hasFile('client_photo')){
            if($testimonial->client_photo != 'default.jpg'){
                unlink(base_path('public/uploads/testimonial_photos/'.$testimonial->client_photo));
            }
            $photo = $request->file('client_photo');
            $photo_name = $testimonial->id.".".$photo->getClientOriginalExtension();
            $photo_location = 'public/uploads/testimonial_photos/'.$photo_name;
            Image::make($photo)->fit(250,250)->save(base_path($photo_location));

            Testimonial::findOrFail($testimonial->id)->update([
                'client_photo' => $photo_name
            ]);
        }

        return back()->with('success_status','Testimonial Edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('delete_status','Testimonial Deleted Successfully!');
    }
}
