<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function list(): View
    {
        return view('items.list', [
            'items' => Item::with(['category', 'supplier'])->orderBy('name')->paginate(15),
        ]);
    }

    public function showCreateForm(): View
    {
        Gate::authorize('create', Item::class);

        return view('items.form', [
            'item' => new Item,
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
            'isUpdate' => false,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        Gate::authorize('create', Item::class);

        $validated = $request->validate($this->validationRules());

        try {
            $item = new Item($validated);
            $item->category()->associate($validated['category_id']);
            $item->supplier()->associate($validated['supplier_id']);
            $item->save();

            return redirect()
                ->route('items.view', $item)
                ->with('status', "Item {$item->sku} was created.");
        } catch (Exception $exception) {
            return $this->databaseFailure('item', $exception);
        }
    }

    public function view(Item $item): View
    {
        return view('items.view', [
            'item' => $item->load(['category', 'supplier']),
        ]);
    }

    public function showUpdateForm(Item $item): View
    {
        Gate::authorize('update', $item);

        return view('items.form', [
            'item' => $item,
            'categories' => Category::orderBy('name')->get(),
            'suppliers' => Supplier::orderBy('name')->get(),
            'isUpdate' => true,
        ]);
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        Gate::authorize('update', $item);

        $validated = $request->validate($this->validationRules($item));

        try {
            $item->fill($validated);
            $item->category()->associate($validated['category_id']);
            $item->supplier()->associate($validated['supplier_id']);
            $item->save();

            return redirect()
                ->route('items.view', $item)
                ->with('status', "Item {$item->sku} was updated.");
        } catch (Exception $exception) {
            return $this->databaseFailure('item', $exception);
        }
    }

    public function delete(Item $item): RedirectResponse
    {
        Gate::authorize('delete', $item);

        try {
            $item->delete();

            return redirect()
                ->route('items.list')
                ->with('status', "Item {$item->sku} was deleted.");
        } catch (Exception $exception) {
            return $this->databaseFailure('item', $exception, false);
        }
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function validationRules(?Item $item = null): array
    {
        $skuRule = 'unique:items,sku';

        if ($item !== null) {
            $skuRule .= ','.$item->id;
        }

        return [
            'sku' => ['required', 'string', 'max:64', $skuRule],
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'supplier_id' => ['required', 'integer', 'exists:suppliers,id'],
            'quantity' => ['required', 'integer', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }
}
