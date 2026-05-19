@extends("layouts.basic")
@section("title")
    Личный кабинет
@endsection

@section("content")
<div class="container mt-5">
    <h2 class="mb-4">Добро пожаловать, {{ Auth::user()->fio }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Мои заявки</h5>
                    <a href="{{ route('order.create') }}" class="btn btn-sm btn-primary">Новая заявка</a>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Курс</th>
                                    <th>Дата</th>
                                    <th>Оплата</th>
                                    <th>Статус</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
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
                                            <form method="POST" action="{{ route('order.destroy', $order) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить заявку?')">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">У вас пока нет заявок</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Оставить отзыв</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('feedback.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="comment" class="form-label">Комментарий</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="3" required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Оценка</label>
                            <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                <option value="">Выберите оценку</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('rating')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Отправить отзыв</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Отзывы</h5>
        </div>
        <div class="card-body">
            @if($feedbacks->count() > 0)
                @foreach($feedbacks as $feedback)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $feedback->user->fio }}</strong>
                            <span class="text-warning">{{ str_repeat('★', $feedback->rating) }}</span>
                        </div>
                        <p class="mt-2 mb-0">{{ $feedback->comment }}</p>
                        <small class="text-muted">{{ $feedback->created_at->format('d.m.Y H:i') }}</small>
                    </div>
                @endforeach
            @else
                <p class="text-muted">Отзывов пока нет</p>
            @endif
        </div>
    </div>
</div>
@endsection
