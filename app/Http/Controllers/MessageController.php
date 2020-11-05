<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Message;
use Carbon\Carbon;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.message.index',[
            'messages' => Message::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.message.trash',[
            'messages' => Message::onlyTrashed()->get()
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
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $message_id = Message::insertGetId($request->except('_token','contact_attachment') + [
            'created_at' => Carbon::now()
        ]);

        if($request->hasFile('contact_attachment')){
            $path = $request->file('contact_attachment')->store('contact_uploads');

            Message::findOrFail($message_id)->update([
                'contact_attachment' => $path
            ]);
        }

        return redirect(url()->previous() .'#frontend_contact')->with('success_status','Message sent successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        if($message->status == 1){
            $message->status = 0;
            $message->save();
        }else{
            $message->status = 1;
            $message->save();

        }

        return back();
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
    public function destroy(Message $message)
    {
        $message->delete();

        return back();
    }


    public function restoremessage($id){
        Message::withTrashed()->findOrFail($id)->restore();
        return back();
    }

    public function deletemessage($id){
        Message::withTrashed()->findOrFail($id)->forcedelete();
        return back();
    }

    public function downloadmessage($id){
        return Storage::download(Message::findOrFail($id)->contact_attachment);
    }
}
