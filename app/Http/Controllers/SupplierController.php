<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function list(): View
    {
        Gate::authorize('viewAny', Supplier::class);

        return view('suppliers.list', [
            'suppliers' => Supplier::withCount('items')
                ->latest()
                ->paginate(10),
        ]);
    }

    public function showCreateForm(): View
    {
        Gate::authorize('create', Supplier::class);

        return view('suppliers.form', [
            'supplier' => new Supplier,
            'isUpdate' => false,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        Gate::authorize('create', Supplier::class);

        $validated = $request->validate($this->validationRules());

        try {
            $supplier = Supplier::create($validated);

            return redirect()
                ->route('suppliers.view', $supplier)
                ->with('status', "Supplier {$supplier->code} was created.");
        } catch (Exception $exception) {
            return $this->databaseFailure('supplier', $exception);
        }
    }

    public function view(Supplier $supplier): View
    {
        Gate::authorize('view', $supplier);

        return view('suppliers.view', [
            'supplier' => $supplier->loadCount('items'),
        ]);
    }

    public function showUpdateForm(Supplier $supplier): View
    {
        Gate::authorize('update', $supplier);

        return view('suppliers.form', [
            'supplier' => $supplier,
            'isUpdate' => true,
        ]);
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        Gate::authorize('update', $supplier);

        $validated = $request->validate($this->validationRules($supplier));

        try {
            $supplier->update($validated);

            return redirect()
                ->route('suppliers.view', $supplier)
                ->with('status', "Supplier {$supplier->code} was updated.");
        } catch (Exception $exception) {
            return $this->databaseFailure('supplier', $exception);
        }
    }

    public function delete(Supplier $supplier): RedirectResponse
    {
        Gate::authorize('delete', $supplier);

        try {
            $supplier->delete();

            return redirect()
                ->route('suppliers.list')
                ->with('status', "Supplier {$supplier->code} was deleted.");
        } catch (Exception $exception) {
            return $this->databaseFailure('supplier', $exception, false);
        }
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function validationRules(?Supplier $supplier = null): array
    {
        $codeRule = 'unique:suppliers,code';

        if ($supplier !== null) {
            $codeRule .= ','.$supplier->id;
        }

        return [
            'code' => ['required', 'string', 'max:64', $codeRule],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }
}
