<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function showFormRegister()
    {
        return view('user/register');
    }

    public function register(RegisterRequest $request)
    {
        if ($this->user->checkUser($request->email)){
               Session::flash('error','invalid email, try again!');
               return view('user/register');
        }

        try {
            $this->user->storeUser($request->name, $request->email, $request->password);
            return redirect()->route('show.login');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }


    }

    public function showFormLogin()
    {
        return view('user/login');
    }

    public function login(LoginRequest $request)
    {
        $username = $request->email;
        $password = $request->password;

        $user = [
            'email' => $username,
            'password' => $password
        ];
        if (Auth::attempt($user)){
            return redirect()->route('index');
        } else {
            Session::flash('error','email or password incorrect');
            return back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
