<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function LoginView()
    {
        return view("auth.login");
    }

    public function RegisterView()
    {
        return view("auth.register");
    }

    public function Register(RegisterRequest $request)
    {
        /** @type User $user */
        $user = User::create($request->all());
        Auth::login($user);
        return redirect()->intended("/");
    }

    public function Login(LoginRequest $request)
    {
        if (Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])) {
            return redirect()->route("account");
        }
        return back()->withErrors(["email" => "Неверный логин или пароль"]);
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route("login");
    }
}
