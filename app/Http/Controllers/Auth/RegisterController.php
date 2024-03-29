<?php

namespace App\Http\Controllers\Auth;

use App\Desk;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Api;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $desk = Desk::where('code', $request->code)->first();
        $user->parent_id = $desk->user_id;
        $user->save();
        $desk->users()->attach($user->id);
        $telegram = new Api('1511098073:AAHi-7hA7JkRoQYWL71KVEwcmDLBjDr7MDY');
        $text = "Был зарегистрирован новый пользователь!\nИмя пользователя: " . $user->name . ",\nПочта пользователя: " . $user->email ."";
        $telegram->sendMessage(['chat_id' => '493742067', 'text' => $text]);
//        return response()->json([
//            'user' => $user,
//        ]);
    }
}
