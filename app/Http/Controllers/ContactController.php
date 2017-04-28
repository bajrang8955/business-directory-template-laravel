<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail, Validator;
use App\Models\Setting;

class ContactController extends Controller {

    public function getIndex()
    {

        return view('frontend/contact');

    }

    public function postIndex(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'captcha' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            return redirect('contact')->withErrors($validator)->withInput();
        }

        Mail::send('emails.contact', ['name' => $request->name, 'email' => $request->email, 'user_message' => $request->message], function($message) {
            $message->to(Setting::get("contact_email"), "Business Directory")->subject('New Contact Form Message');
        });

        flash()->success("Thanks for contacting us. The message has been sent.");
        return redirect('contact');
    }



}