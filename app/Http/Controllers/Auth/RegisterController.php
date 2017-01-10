<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Order;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'username' => 'required|max:30|unique:users',
            'email' => 'required|email|max:255',
            'surname' => 'required|max:60',
            'firstname' => 'required|max:60',            
            'password' => 'required|min:4|confirmed',
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
        $confirmation_code = str_random(32);

        $data['link'] = '/register/confirm/' . $confirmation_code;

        Mail::send('layouts.mailconfirm', $data, function ($message) use ($data) {
                $message->to($data['email'])
                    ->subject('Auction confirm registration ' . $data['username']);
            });

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'surname' => $data['surname'],
            'firstname' => $data['firstname'],
            'password' => bcrypt($data['password']),
            'confirmation_code' => $confirmation_code,
        ]);

    }
}
