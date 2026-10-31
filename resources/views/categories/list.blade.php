@extends('layouts.main', ['title' => 'Categories'])

@section('content')
    <div class="content-toolbar">
        <p class="muted">Browse the categories used to organize inventory.</p>
        @can('create', \App\Models\Category::class)
            <a class="button" href="{{ route('categories.create-form') }}">Add category</a>
        @endcan
    </div>

    @if ($categories->isEmpty())
        <div class="empty-state">No categories have been added yet.</div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td><a href="{{ route('categories.view', $category) }}">{{ $category->code }}</a></td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description ?: '—' }}</td>
                            <td>{{ $category->items_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $categories->links() }}
    @endif
@endsection
