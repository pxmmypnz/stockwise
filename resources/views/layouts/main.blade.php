<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#163B65">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>{{ $title }} | StockWise</title>
</head>

<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('home') }}" aria-label="StockWise home">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 19V9l8-5 8 5v10" />
                        <path d="M8 19v-6h8v6M4 9l8 5 8-5" />
                    </svg>
                </span>
                <span class="brand-copy">
                    <strong>StockWise</strong>
                    <small>INVENTORY PLATFORM</small>
                </span>
            </a>

            <div class="sidebar-section-label">WORKSPACE</div>
            <nav class="sidebar-nav" aria-label="Main navigation">
                <a @class(['sidebar-link', 'active' => Route::is('home')]) href="{{ route('home') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5" /><rect x="14" y="3" width="7" height="7" rx="1.5" /><rect x="14" y="14" width="7" height="7" rx="1.5" /><rect x="3" y="14" width="7" height="7" rx="1.5" /></svg>
                    <span>Overview</span>
                </a>

                @if (Route::has('items.list'))
                    <a @class(['sidebar-link', 'active' => Route::is('items.*')]) href="{{ route('items.list') }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 9 5-9 5-9-5 9-5Z" /><path d="m3 12 9 5 9-5M3 16l9 5 9-5" /></svg>
                        <span>Inventory</span>
                    </a>
                @endif

                @if (Route::has('categories.list'))
                    <a @class(['sidebar-link', 'active' => Route::is('categories.*')]) href="{{ route('categories.list') }}">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H20v14H5.5A1.5 1.5 0 0 0 4 19.5v-14Z" /><path d="M4 19.5A1.5 1.5 0 0 1 5.5 18H20M8 8h8M8 11h6" /></svg>
                        <span>Categories</span>
                    </a>
                @endif

                @auth
                    @if (Route::has('suppliers.list'))
                        <a @class(['sidebar-link', 'active' => Route::is('suppliers.*')]) href="{{ route('suppliers.list') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h.01M15 10h.01M9 14h.01M15 14h.01M10 21v-3h4v3" /></svg>
                            <span>Suppliers</span>
                        </a>
                    @endif

                    @if (Route::has('reports.low-stock'))
                        <a @class(['sidebar-link', 'active' => Route::is('reports.*')]) href="{{ route('reports.low-stock') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10.3 4.3 2.8 17.2A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.7-2.8L13.7 4.3a2 2 0 0 0-3.4 0Z" /><path d="M12 9v4M12 17h.01" /></svg>
                            <span>Low-stock report</span>
                        </a>
                    @endif
                @endauth
            </nav>

            <div class="sidebar-bottom">
                <div class="sidebar-divider"></div>
                @auth
                    <div class="profile-card">
                        <span class="avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="profile-copy">
                            <strong>{{ auth()->user()->name }}</strong>
                            <small>{{ auth()->user()->role }}</small>
                        </span>
                        @if (Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="icon-button" type="submit" aria-label="Log out" title="Log out">
                                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10 17l5-5-5-5M15 12H3M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" /></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @else
                    @if (Route::has('login'))
                        <a @class(['sidebar-link', 'active' => Route::is('login')]) href="{{ route('login') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M15 12H3" /></svg>
                            <span>Staff login</span>
                        </a>
                    @endif
                @endauth
                <p class="sidebar-footnote">Inventory clarity for every team.</p>
            </div>
        </aside>

        <div class="main-panel">
            <header class="topbar">
                <div class="topbar-heading">
                    <span class="topbar-eyebrow">STOCKWISE WORKSPACE</span>
                    <h1>{{ $title }}</h1>
                </div>

                <div class="topbar-user">
                    <span class="topbar-status"><span></span> System active</span>
                    @auth
                        <span class="avatar avatar-small" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="topbar-user-name">{{ auth()->user()->name }}</span>
                    @else
                        @if (Route::has('login'))
                            <a class="button button-small" href="{{ route('login') }}">Sign in</a>
                        @endif
                    @endauth
                </div>
            </header>

            <main class="page-shell">
                @if (session()->has('status') || $errors->has('alert'))
                    <div class="notifications" aria-live="polite">
                        @session('status')
                            <div class="flash flash-success" role="status">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
                                {{ $value }}
                            </div>
                        @endsession

                        @error('alert')
                            <div class="flash flash-error" role="alert">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M12 8v4M12 16h.01" /></svg>
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
                <span>&copy; {{ date('Y') }} StockWise</span>
                <span>Inventory management, made clear.</span>
            </footer>
        </div>
    </div>
</body>

</html>
