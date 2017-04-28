<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator, Mail, Auth, Hash;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    protected $redirectTo = '';
    protected $loginPath = '/login';


    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'termsconditions' => 'required',
            'captcha' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $confirmation_code = str_random(30);

        $user = User::create([
            'first_name' => $data['firstname'],
            'last_name' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => $confirmation_code,
        ]);


        if($user){
            Mail::send('emails.verify', ['confirmation_code' => $confirmation_code], function($message) use ($data) {
                $message->to($data['email'], $data['firstname'].' '.$data['lastname'])->subject('Verify your email address');
            });
        }

        flash()->success('Please click on the link in the email you have received to verify your email address.');

        return $user;


    }


    // override default postLogin
    public function postLogin(Request $request)
    {

        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        $throttles = $this->isUsingThrottlesLoginsTrait();
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        if (Auth::validate(['email' => $request->email, 'password' => $request->password, 'confirmed' => 0])) {

            if($user->confirmation_code == null)
            {
                $confirmation_code = str_random(30);
                $user->confirmation_code = $confirmation_code;
                $user->save();
            }

            Mail::send('emails.verify', ['confirmation_code' => $user->confirmation_code], function($message) use ($user) {
                $message->to($user->email, $user->firstname.' '. $user->lastname)->subject('Verify your email address');
            });

            return redirect($this->loginPath())
                ->withInput($request->only('email', 'remember'))
                ->withErrors('Your account is not verified. Please check your email inbox.');
        }

        $credentials = $this->getCredentials($request);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    // override default postRegister
    public function postRegister(Request $request)
    {


        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $this->create($request->all());
        return redirect($this->redirectPath());
    }


}
