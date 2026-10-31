@extends('layouts.main', ['title' => $isUpdate ? 'Update item' : 'Create item'])

@section('content')
    <div class="form-card">
        <form method="POST"
            action="{{ $isUpdate ? route('items.update', $item) : route('items.create') }}"
            class="stacked-form">
            @csrf

            <label for="sku">SKU</label>
            <input id="sku" name="sku" value="{{ old('sku', $item->sku) }}" maxlength="64" required>
            @error('sku')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <label for="name">Name</label>
            <input id="name" name="name" value="{{ old('name', $item->name) }}" maxlength="255" required>
            @error('name')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) old('category_id', $item->category_id) === (string) $category->id)>
                        {{ $category->name }} ({{ $category->code }})
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <label for="supplier_id">Supplier</label>
            <select id="supplier_id" name="supplier_id" required>
                <option value="">Select a supplier</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" @selected((string) old('supplier_id', $item->supplier_id) === (string) $supplier->id)>
                        {{ $supplier->name }} ({{ $supplier->code }})
                    </option>
                @endforeach
            </select>
            @error('supplier_id')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <label for="quantity">Quantity</label>
            <input id="quantity" name="quantity" type="number" min="0" step="1"
                value="{{ old('quantity', $item->quantity ?? 0) }}" required>
            @error('quantity')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <label for="reorder_level">Reorder level</label>
            <input id="reorder_level" name="reorder_level" type="number" min="0" step="1"
                value="{{ old('reorder_level', $item->reorder_level ?? 0) }}" required>
            @error('reorder_level')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <label for="price">Price</label>
            <input id="price" name="price" type="number" min="0" step="0.01"
                value="{{ old('price', $item->price ?? '0.00') }}" required>
            @error('price')
                <span class="field-error">{{ $message }}</span>
            @enderror

            <div class="action-row">
                <button class="button" type="submit">{{ $isUpdate ? 'Save changes' : 'Create item' }}</button>
                <a class="button button-secondary" href="{{ route('items.list') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection
