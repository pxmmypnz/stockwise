@extends('layouts.main', ['title' => 'Low-stock report'])

@section('content')
    <div class="content-toolbar">
        <p class="muted">Items are low on stock when their quantity is at or below the reorder level.</p>
        <a class="button" href="{{ route('reports.low-stock.pdf') }}">Download PDF</a>
    </div>

    @include('reports._table')
@endsection
