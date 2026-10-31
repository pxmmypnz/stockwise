<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function list(): View
    {
        return view('categories.list', [
            'categories' => Category::withCount('items')->orderBy('name')->paginate(15),
        ]);
    }

    public function showCreateForm(): View
    {
        Gate::authorize('create', Category::class);

        return view('categories.form', [
            'category' => new Category,
            'isUpdate' => false,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        Gate::authorize('create', Category::class);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:64', 'unique:categories,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            $category = Category::create($validated);

            return redirect()
                ->route('categories.view', $category)
                ->with('status', "Category {$category->code} was created.");
        } catch (Exception $exception) {
            return $this->databaseFailure('category', $exception);
        }
    }

    public function view(Category $category): View
    {
        return view('categories.view', [
            'category' => $category->loadCount('items'),
        ]);
    }

    public function showUpdateForm(Category $category): View
    {
        Gate::authorize('update', $category);

        return view('categories.form', [
            'category' => $category,
            'isUpdate' => true,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        Gate::authorize('update', $category);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:64', 'unique:categories,code,'.$category->id],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            $category->update($validated);

            return redirect()
                ->route('categories.view', $category)
                ->with('status', "Category {$category->code} was updated.");
        } catch (Exception $exception) {
            return $this->databaseFailure('category', $exception);
        }
    }

    public function delete(Category $category): RedirectResponse
    {
        Gate::authorize('delete', $category);

        try {
            $category->delete();

            return redirect()
                ->route('categories.list')
                ->with('status', "Category {$category->code} was deleted.");
        } catch (Exception $exception) {
            return $this->databaseFailure('category', $exception, false);
        }
    }
}
