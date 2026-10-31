<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ $title }} | StockWise</title>
</head>

<body>
    <header class="site-header">
        <nav class="site-nav" aria-label="Main navigation">
            <a class="brand" href="{{ route('home') }}">StockWise</a>

            <div class="nav-links">
                @if (Route::has('items.list'))
                    <a @class(['nav-link', 'active' => Route::is('items.*')]) href="{{ route('items.list') }}">
                        Items
                    </a>
                @endif

                @if (Route::has('categories.list'))
                    <a @class(['nav-link', 'active' => Route::is('categories.*')]) href="{{ route('categories.list') }}">
                        Categories
                    </a>
                @endif

                @auth
                    @if (Route::has('suppliers.list'))
                        <a @class(['nav-link', 'active' => Route::is('suppliers.*')]) href="{{ route('suppliers.list') }}">
                            Suppliers
                        </a>
                    @endif

                    @if (Route::has('reports.low-stock'))
                        <a @class(['nav-link', 'active' => Route::is('reports.*')]) href="{{ route('reports.low-stock') }}">
                            Low-stock report
                        </a>
                    @endif
                @endauth
            </div>

            <div class="nav-user">
                @auth
                    <span class="user-greeting">Welcome, {{ auth()->user()->name }}</span>
                    @if (Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="button button-small button-outline" type="submit">Logout</button>
                        </form>
                    @endif
                @else
                    @if (Route::has('login'))
                        <a @class(['nav-link', 'active' => Route::is('login')]) href="{{ route('login') }}">Login</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main class="page-shell">
        <div class="page-heading">
            <h1>{{ $title }}</h1>
        </div>

        @if (session()->has('status') || $errors->has('alert'))
            <div class="notifications" aria-live="polite">
                @session('status')
                    <div class="flash flash-success" role="status">
                        {{ $value }}
                    </div>
                @endsession

                @error('alert')
                    <div class="flash flash-error" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        <section class="page-content">
            @yield('content')
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} StockWise</p>
    </footer>
</body>

</html>
