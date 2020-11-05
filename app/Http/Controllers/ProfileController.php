<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Auth;
use Carbon\Carbon;
use Hash;
use Image;
use Mail;
use App\Mail\ChangePasswordMail;

class ProfileController extends Controller
{
    public function profile(){
    	return view('admin.profile.index');
    }

    public function editprofilepost(Request $request){
    	$request->validate([
    		'name' => 'required'
    	]);

    	if (Auth::user()->updated_at->addDays(30) < Carbon::now()) {
	    	User::find(Auth::id())->update([
	    		'name' => $request->name
	    	]);
	    	return back()->with('name_change_msg','Name Changed Successfully!');
    	}
    	else{
    		$left = Carbon::now()->diffInDays(Auth::user()->updated_at->addDays(31));
	    	return back()->with('name_change_error','Wait '.$left.' more days to change your name!');
    	}

    }

    public function editpasswordpost(Request $request){
        Mail::to(Auth::user()->email)->send(new ChangePasswordMail(Auth::user()->name));
                echo "Success";
    	$request->validate([
    		'password' => 'min:8|confirmed|alpha_num'
    	]);

    	if (Hash::check($request->old_password, Auth::user()->password)) {
    		if ($request->old_password != $request->password) {
    			User::find(Auth::id())->update([
    				'password' => Hash::make($request->password)
    			]);

                //Send password change notificatin
                

    			// return back()->with('password_change','Password changed successfully!');
    		}else{
    			return back()->with('password_error','Old password can\'t be set again!!');
    		}
    	}else{
    		return back()->with('password_error','Your old password hasn\'t matched!!');
    	}
    }

    public function changeprofilephoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image',
        ]);

        if ($request->hasFile('profile_photo')) {
            if (Auth::user()->profile_photo != 'default.jpg') {
                $old_photo_location = 'public/uploads/profile_photos/'.Auth::user()->profile_photo;
                unlink(base_path($old_photo_location));
            }
            $upload_photo = $request->file('profile_photo');
            $new_photo_name = Auth::id().".".$upload_photo->getClientOriginalExtension();
            $new_photo_location = 'public/uploads/profile_photos/'.$new_photo_name;
            Image::make($upload_photo)->fit(250,250)->save(base_path($new_photo_location));

            User::find(Auth::id())->update([
                'profile_photo' => $new_photo_name
            ]);

            return back();
        }else{
            echo "Nai";
        }
    }
}
