<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <title>Stock Manager</title>
</head>

<body>

    <header class="site-header">
        <nav>
            <ul>
                @auth
                    <li @class(['active' => Route::is('items.*')])>
                        <a href="{{ route('items.list') }}">Items</a>
                    </li>

                    <li @class(['active' => Route::is('categories.*')])>
                        <a href="{{ route('categories.list') }}">Categories</a>
                    </li>

                    <li @class(['active' => Route::is('suppliers.*')])>
                        <a href="{{ route('suppliers.list') }}">Suppliers</a>
                    </li>
                @endauth
                <li @class(['active' => Route::is('reports.*')])>
                    <a href="{{ route('reports.low-stock') }}">
                        Low-stock Report
                    </a>
                </li>
            </ul>
            <ul>
                @auth
                    <li>
                        <span>Welcome, {{ auth()->user()->name }}</span>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li @class(['active' => Route::is('login')])>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                @endauth
            </ul>
        </nav>
    </header>

    <main>
        <h1>{{ $title }}</h1>

        <div class="notifications">
            @session('status')
                <div role="status">
                    {{ $value }}
                </div>
            @endsession

            @error('alert')
                <div role="alert">
                    {{ $message }}
                </div>
            @enderror
        </div>

        @yield('content')
    </main>

    <footer class="site-footer">
        &copy; Stock Wise
    </footer>

</body>

</html>
