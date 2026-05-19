@extends("layouts.basic")
@section("title")
    Панель администратора
@endsection

@section("content")
<div class="container mt-5">
    <h2 class="mb-4">Панель администратора</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Все заявки</h5>
        </div>
        <div class="card-body">
            @if($orders->count() > 0)
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>ФИО</th>
                            <th>Курс</th>
                            <th>Дата</th>
                            <th>Оплата</th>
                            <th>Статус</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->fio }}</td>
                                <td>{{ $order->course_name }}</td>
                                <td>{{ $order->date->format('d.m.Y') }}</td>
                                <td>{{ $order->payment_type == 'money' ? 'Реальные деньги' : 'Через телефон' }}</td>
                                <td>
                                    @if($order->status === \App\Enum\OrderStatus::New)
                                        <span class="badge bg-primary">Новая</span>
                                    @elseif($order->status === \App\Enum\OrderStatus::Middle)
                                        <span class="badge bg-warning">Идёт обучение</span>
                                    @else
                                        <span class="badge bg-success">Обучение завершено</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.order.updateStatus', $order) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="d-flex gap-2">
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="New" {{ $order->status === \App\Enum\OrderStatus::New ? 'selected' : '' }}>Новая</option>
                                                <option value="Middle" {{ $order->status === \App\Enum\OrderStatus::Middle ? 'selected' : '' }}>Идёт обучение</option>
                                                <option value="End" {{ $order->status === \App\Enum\OrderStatus::End ? 'selected' : '' }}>Обучение завершено</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Обновить</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Заявок пока нет</p>
            @endif
        </div>
    </div>
</div>
@endsection
