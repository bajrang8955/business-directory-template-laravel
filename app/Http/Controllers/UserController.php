<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth, Hash, Mailchimp;
use App\Models\User;
use App\Models\Setting;
//use Illuminate\Contracts\Auth\Authenticatable;

class UserController extends Controller {

    public function getConfirmcode($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            return redirect('');
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            return redirect('');
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        try {
            if(Setting::get("use_mailchimp") == "1") {
                Mailchimp::subscribe(Setting::get("mailchimp_list_id"), $user->email, [], true);
            }
        } catch (Exception $e) {
            
        }

        Auth::loginUsingId($user->id);

        flash()->success('You have successfully verified your account.');

        return redirect('');

    }

    public function getAccount()
    {
         return view('frontend/user/account');
    }

    public function getChangePassword()
    {
         return view('frontend/user/changepassword');
    }

    public function postChangePassword(Request $request)
    {

        $user = User::find(Auth::user()->id);

        if($user && isset($request->password) && $request->password != ""){

            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);

                if($user->save()){
                    flash()->success('Password changed.');
                    return redirect('change-password');
                }

            }else{
                flash()->error('Passwords do not match.');
                return redirect('change-password');
            }
        }

        flash()->error('An error occured.');
        return redirect('change-password');

    }



}