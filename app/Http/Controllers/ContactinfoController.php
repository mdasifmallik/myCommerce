<?php

namespace App\Http\Controllers;

use App\Contactinfo;
use Illuminate\Http\Request;

class ContactinfoController extends Controller
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

    public function index()
    {
        return view('admin.contact_info.index', [
            'contact_info' => Contactinfo::findOrFail(1)
        ]);
    }

    public function update_contactinfo(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'map_embedd_link' => 'required'
        ]);

        Contactinfo::findOrFail(1)->update($request->except('_token'));

        return back();
    }
}
