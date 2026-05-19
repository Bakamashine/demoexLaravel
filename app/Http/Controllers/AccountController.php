<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __invoke()
    {
        $orders = Auth::user()->orders()->latest()->get();
        $feedbacks = Feedback::with('user')->latest()->get();
        return view("account", compact('orders', 'feedbacks'));
    }
}
