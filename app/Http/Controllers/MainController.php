<?php

namespace App\Http\Controllers;

use App\Models\Feedback;

class MainController extends Controller
{
    public function __invoke()
    {
        $feedbacks = Feedback::with('user')->latest()->get();
        return view("index", compact('feedbacks'));
    }
}
