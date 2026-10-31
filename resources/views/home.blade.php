@extends('layouts.main', ['title' => 'Welcome to StockWise'])

@section('content')
    <div class="hero">
        <p class="hero-label">Stock management, made simple</p>
        <h2>A clearer view of your inventory starts here.</h2>
        <p class="hero-copy">
            StockWise helps your team keep items, categories, and suppliers organized,
            so you can focus on the work that keeps your business moving.
        </p>

        <div class="hero-actions">
            @if (Route::has('items.list'))
                <a class="button" href="{{ route('items.list') }}">Browse items</a>
            @endif

            @if (Route::has('categories.list'))
                <a class="button" href="{{ route('categories.list') }}">Browse categories</a>
            @endif

            @guest
                @if (Route::has('login'))
                    <a class="button" href="{{ route('login') }}">Staff login</a>
                @endif
            @endguest
        </div>
    </div>
@endsection
