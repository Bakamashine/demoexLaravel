<?php

namespace App\Http\Controllers;

use App\Enum\OrderStatus;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create()
    {
        return view("order.create");
    }

    public function store(OrderRequest $request)
    {
        Order::create([
            'user_id' => Auth::id(),
            'course_name' => $request->course_name,
            'date' => $request->date,
            'payment_type' => $request->payment_type,
            'status' => OrderStatus::New,
        ]);

        return redirect()->route('account')->with('success', 'Заявка успешно создана');
    }

    public function destroy(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->delete();

        return redirect()->route('account')->with('success', 'Заявка удалена');
    }
}
