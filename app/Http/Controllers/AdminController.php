<?php

namespace App\Http\Controllers;

use App\Enum\OrderStatus;
use App\Http\Requests\AdminAuthRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginView()
    {
        return view("admin.login");
    }

    public function login(AdminAuthRequest $request)
    {
        $user = \App\Models\User::where('login', $request->login)->first();

        if ($user && $user->role === \App\Enum\UserRole::Admin &&
            \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('admin.index');
        }

        return back()->withErrors(['login' => 'Неверный логин или пароль']);
    }

    public function index()
    {
        $orders = Order::with('user')->latest()->get();
        return view("admin.index", compact('orders'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        switch ($request->status) {
            case 'New':
                $status = OrderStatus::New;
                break;
            case 'Middle':
                $status = OrderStatus::Middle;
                break;
            case 'End':
                $status = OrderStatus::End;
                break;
        }

        $order->update([
            'status' => $status,
        ]);

        return redirect()->route('admin.index')->with('success', 'Статус заявки обновлен');
    }
}
