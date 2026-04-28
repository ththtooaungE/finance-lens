<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service) 
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) 
    {
        $categories = $this->service->paginate(15);

        if($request->ajax()) {
            $categories = Category::select(
                'id',
                'user_id',
                'name',
                'is_active',
                'created_at'
            );

            return datatables()
                ->of($categories)
                ->editColumn('is_active', function ($category) {
                    return $category->is_active ? 'True' : '-';
                })
                ->editColumn('created_at', function ($category) {
                    return $category->created_at->format('Y-m-d h:i');
                })
                ->addColumn('actions', function ($category) {
                    $editUrl = route('admin.categories.edit', $category->id);
                    $deleteUrl = route('admin.categories.destroy', $category->id);

                    $btn = '<a href="'. $editUrl . '" class="btn btn-sm btn-primary mr-2">Edit</a>';
                    $btn .= '<form action="'
                    . $deleteUrl
                    . '" method="post" style="display:inline-block">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function getMine() {
        $categories = $this->service->getMine();

        return view('admin.categories.index', compact($categories));
    }

    public function create(): View 
    {
        return view('admin.categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();

            $this->service->create($data);

            return redirect()->route('admin.categories.index')->with('status', 'Category created successfully!');

        } catch (\Throwable $e) {
            \Log::error('Category store failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to create category!');
        }
    }

    public function edit(Request $request, $id) 
    {
        $category = $this->service->find($id);

        if(!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Category Not Found!');
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, $id) 
    {
        try {
            $category = $this->service->find($id);

            if (!$category) {
                return redirect()
                    ->route('admin.categories.index')
                    ->with('error', 'Category Not Found!');
            }

            $data = $request->validated();
            $this->service->update($category->id, $data);

            return redirect()->route('admin.categories.index')->with('status', 'Category updated successfully!');

        } catch (\Throwable $e) {
            \Log::error('Category update failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to update category.');
        }
    }

    public function delete($id) 
    {
        try {
            $category = $this->service->find($id);

            if(!$category) {
                return back()->with('error', 'Failed to delete category.');
            }

            $this->service->delete($category->id);

            return redirect()->route('admin.categories.index')->with('status', 'Category deleted successfully!');
            
        } catch (\Throwable $e) {
            \Log::error('Category delete failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to delete category.');
        }
    }

    
}
