@extends('layouts.main', ['title' => 'Overview'])

@section('content')
    <div class="welcome-row">
        <div>
            <p class="section-kicker">YOUR WORKSPACE</p>
            <h2 class="section-title">Inventory at a glance</h2>
            <p class="section-description">Choose a workspace to review stock and keep operations moving.</p>
        </div>
        <span class="date-chip">
            <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2" /><path d="M16 3v4M8 3v4M3 10h18" /></svg>
            {{ now()->format('M j, Y') }}
        </span>
    </div>

    <div class="dashboard-grid">
        <a class="dashboard-card" href="{{ route('items.list') }}">
            <span class="dashboard-card-icon icon-blue">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m12 3 9 5-9 5-9-5 9-5Z" /><path d="m3 12 9 5 9-5M3 16l9 5 9-5" /></svg>
            </span>
            <span class="dashboard-card-label">INVENTORY</span>
            <strong>Item catalog</strong>
            <span class="dashboard-card-description">Browse products and current stock levels.</span>
            <span class="dashboard-card-link">View inventory <span aria-hidden="true">→</span></span>
        </a>

        <a class="dashboard-card" href="{{ route('categories.list') }}">
            <span class="dashboard-card-icon icon-violet">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A1.5 1.5 0 0 1 5.5 4H20v14H5.5A1.5 1.5 0 0 0 4 19.5v-14Z" /><path d="M4 19.5A1.5 1.5 0 0 1 5.5 18H20M8 8h8M8 11h6" /></svg>
            </span>
            <span class="dashboard-card-label">ORGANIZATION</span>
            <strong>Categories</strong>
            <span class="dashboard-card-description">Explore the groups used to organize items.</span>
            <span class="dashboard-card-link">View categories <span aria-hidden="true">→</span></span>
        </a>

        @auth
            <a class="dashboard-card" href="{{ route('suppliers.list') }}">
                <span class="dashboard-card-icon icon-teal">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h.01M15 10h.01M9 14h.01M15 14h.01M10 21v-3h4v3" /></svg>
                </span>
                <span class="dashboard-card-label">PARTNERS</span>
                <strong>Suppliers</strong>
                <span class="dashboard-card-description">Review supplier contacts and linked items.</span>
                <span class="dashboard-card-link">View suppliers <span aria-hidden="true">→</span></span>
            </a>

            <a class="dashboard-card dashboard-card-alert" href="{{ route('reports.low-stock') }}">
                <span class="dashboard-card-icon icon-amber">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10.3 4.3 2.8 17.2A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.7-2.8L13.7 4.3a2 2 0 0 0-3.4 0Z" /><path d="M12 9v4M12 17h.01" /></svg>
                </span>
                <span class="dashboard-card-label">ATTENTION</span>
                <strong>Low-stock alerts</strong>
                <span class="dashboard-card-description">Review items that are at or below reorder level.</span>
                <span class="dashboard-card-link">Open stock report <span aria-hidden="true">→</span></span>
            </a>
        @else
            <a class="dashboard-card" href="{{ route('login') }}">
                <span class="dashboard-card-icon icon-amber">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M10.3 4.3 2.8 17.2A2 2 0 0 0 4.5 20h15a2 2 0 0 0 1.7-2.8L13.7 4.3a2 2 0 0 0-3.4 0Z" /><path d="M12 9v4M12 17h.01" /></svg>
                </span>
                <span class="dashboard-card-label">STAFF WORKSPACE</span>
                <strong>Low-stock alerts</strong>
                <span class="dashboard-card-description">Sign in to review stock alerts and supplier details.</span>
                <span class="dashboard-card-link">Staff sign in <span aria-hidden="true">→</span></span>
            </a>
        @endauth
    </div>

    <div class="dashboard-note">
        <span class="dashboard-note-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3a7 7 0 0 0-4 12.7V19h8v-3.3A7 7 0 0 0 12 3Z" /><path d="M9 22h6M9 16h6" /></svg>
        </span>
        <p><strong>A clear view of your stock.</strong> Use the workspace links to browse the catalog or sign in to manage inventory.</p>
    </div>
@endsection
