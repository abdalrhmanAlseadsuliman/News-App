<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\NewSubscriber;
use App\Http\Controllers\Controller;
use App\Mail\Frontend\NewSubscriberMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NewSubscribeController extends Controller
{
    public function store(Request $request){
        $request->validate([
            "email"=>["required","email",'unique:new_subscribers,email'],
        ]);

        $newSubscriber = NewSubscriber::create([
            'email'=>$request->email,
        ]);

        if(!$newSubscriber){
            Session::flash('error','sorry try agin later');
            return redirect()->back();
        }
        Mail::to($request->email)->send(new NewSubscriberMail());
        Session::flash('success','Thanks for subscribe');
        return redirect()->back();

    }
}
