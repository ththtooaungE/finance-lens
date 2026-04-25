<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index() 
    {
        $categories = Category::take(10)->get();
        // return $categories;
        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View 
    {
        return view('admin.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            \Log::info('Category Request', [
                'all' => $request->all()
            ]);
            $data = $request->validated();
            $data['user_id'] = auth()->id();

            Category::create($data);

            return redirect()
                ->route('admin.categories.index')
                ->with('status', 'Category created successfully.');
        } catch (\Throwable $e) {
            \Log::error('Category store failed', [
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create category.');
        }
    }

    public function edit(Request $request, $id) 
    {
        $category = Category::findOrFail($id);

        if(!$category) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Category Not Found!');
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, $id) 
    {
        try {
            $category = Category::findOrFail($id);

            if (!$category) {
                return redirect()
                    ->route('admin.categories.index')
                    ->with('error', 'Category Not Found!');
            }

            $data = $request->validated();
            $category->update($data);

            return redirect()
                ->route('admin.categories.index')
                ->with('status', 'Category updated successfully!');
        } catch (\Throwable $e) {
            \Log::error('Category update failed', [
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update category.');
        }
    }

    public function delete($id) 
    {
        try {
            $category = Category::findOrFail($id);

            if(!$category) {
                return back()
                    ->with('error', 'Failed to delete category.');
            }

            $category->delete();

            return redirect()
                ->route('admin.categories.index')
                ->with('status', 'Category deleted successfully!');
        } catch (\Throwable $e) {
            \Log::error('Category delete failed', [
                'error' => $e->getMessage()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to delete category.');
        }
    }
}
