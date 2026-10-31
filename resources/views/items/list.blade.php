@extends('layouts.main', ['title' => 'Items'])

@section('content')
    <div class="content-toolbar">
        <p class="muted">Browse the current inventory. Sign in to manage stock details.</p>
        @can('create', \App\Models\Item::class)
            <a class="button" href="{{ route('items.create-form') }}">Add item</a>
        @endcan
    </div>

    @if ($items->isEmpty())
        <div class="empty-state">No items have been added yet.</div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        @auth
                            <th>Reorder level</th>
                            <th>Supplier</th>
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td><a href="{{ route('items.view', $item) }}">{{ $item->sku }}</a></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>
                                <span @class(['stock-count', 'stock-low' => auth()->check() && $item->quantity <= $item->reorder_level])>
                                    {{ $item->quantity }}
                                </span>
                            </td>
                            @auth
                                <td>{{ $item->reorder_level }}</td>
                                <td>{{ $item->supplier->name }}</td>
                            @endauth
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    @endif
@endsection
