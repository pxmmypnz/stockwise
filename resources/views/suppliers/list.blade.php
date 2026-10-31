@extends('layouts.main', ['title' => 'Suppliers'])

@section('content')
    <div class="content-toolbar">
        <p class="muted">Supplier details are available to signed-in staff.</p>
        @can('create', \App\Models\Supplier::class)
            <a class="button" href="{{ route('suppliers.create-form') }}">Add supplier</a>
        @endcan
    </div>

    @if ($suppliers->isEmpty())
        <div class="empty-state">No suppliers have been added yet.</div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                        <tr>
                            <td><a href="{{ route('suppliers.view', $supplier) }}">{{ $supplier->code }}</a></td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td><a href="mailto:{{ $supplier->email }}">{{ $supplier->email }}</a></td>
                            <td>{{ $supplier->items_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $suppliers->links() }}
    @endif
@endsection
