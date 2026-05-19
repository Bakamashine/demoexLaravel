@extends("layouts.basic")

@section("title")
    Главная страница
@endsection

@section("content")
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            @php
                $images = ['image01.webp', 'image02.jpg', 'image03.png', 'image04.jpg'];
            @endphp
            @foreach($images as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset("media/$image") }}" class="d-block w-100" alt="Слайд {{ $index + 1 }}">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Предыдущий</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Следующий</span>
        </button>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Отзывы</h2>
        @if($feedbacks->count() > 0)
            @foreach($feedbacks as $feedback)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $feedback->user->fio }}</strong>
                            <span class="text-warning">{{ str_repeat('★', $feedback->rating) }}</span>
                        </div>
                        <p class="mt-2 mb-0">{{ $feedback->comment }}</p>
                        <small class="text-muted">{{ $feedback->created_at->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">Отзывов пока нет</p>
        @endif
    </div>
@endsection
