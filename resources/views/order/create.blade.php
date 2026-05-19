@extends("layouts.basic")
@section("title")
    Создать заявку
@endsection

@section("content")
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Создание заявки</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('order.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="course_name" class="form-label">Название курса</label>
                            <input type="text" class="form-control @error('course_name') is-invalid @enderror" id="course_name" name="course_name" value="{{ old('course_name') }}" required>
                            @error('course_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Дата</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}" required>
                            @error('date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Тип оплаты</label>
                            <div class="form-check">
                                <input class="form-check-input @error('payment_type') is-invalid @enderror" type="radio" name="payment_type" id="payment_money" value="money" {{ old('payment_type') == 'money' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="payment_money">
                                    Реальные деньги
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_type" id="payment_phone" value="phone" {{ old('payment_type') == 'phone' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_phone">
                                    Оплата через телефон
                                </label>
                            </div>
                            @error('payment_type')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Создать заявку</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
