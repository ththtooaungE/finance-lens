<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

use function Laravel\Prompts\datatable;

class CategoryController extends Controller
{
    public function __construct(public CategoryService $service)
    {}

    public function index(Request $request) {

        if($request->ajax()) {
            $categories = Category::select(
                'id',
                'user_id',
                'name',
                'color',
                'is_active',
                'created_at'
            )
            ->whereIn('user_id', ['1',auth()->id()])
            ->where('is_active', true)
            ->with('user:id,name');

            return datatables()
                ->of($categories)
                ->editColumn('color', function ($category) {
                    return '<span class="badge badge-pill" style="background-color: ' . $category->color . ';">&nbsp;&nbsp;</span>';
                })
                ->editColumn('created_at', function ($category) {
                    return $category->created_at->format('Y-m-d h:i');
                })
                ->addIndexColumn()
                ->rawColumns(['color'])
                ->make(true);
        }
        return view('categories.index',[
            'ajaxUrl' => route('user.categories.index')
        ]);
    }

    
    public function getMyCategory(Request $request) 
    {
        if ($request->ajax()) {
            $categories = $this->service->getMine();

            return datatables()
                ->of($categories)
                ->editColumn('color', function ($category) {
                    return '<span class="badge badge-pill" style="background-color: ' . $category->color . ';">&nbsp;&nbsp;</span>';
                })
                ->editColumn('is_active', function ($category) {
                return $category->is_active
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-secondary">Inactive</span>';                })
                ->editColumn('created_at', function ($category) {
                    return optional($category->created_at)->format('Y-m-d h:i');
                })
                ->addColumn('actions', function ($category) {
                    $editUrl = route('user.categories.edit', $category->id);
                    $deleteUrl = route('user.categories.destroy', $category->id);

                    $btn = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary mr-2">Edit</a>';
                    $btn .= '<form action="' . $deleteUrl . '" method="post" id="delete-form-' . $category->id . '" style="display:inline-block">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete( '. $category->id . ')">Delete</button>
                    </form>';
                    return $btn;
                })
                ->rawColumns(['color', 'actions', 'is_active'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('categories.mine', [
            'ajaxUrl' => route('user.categories.mine'),
            'createUrl' => route('user.categories.create')
        ]);
    }

    public function create() : View 
    {
        return view('categories.create',[
            'storeUrl' => route('user.categories.store')
        ]);
    }

    public function store(CategoryStoreRequest $request) {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();

            $this->service->create($data);

            return redirect()->route('user.categories.mine')->with('success', 'Category created successfully!');
        } catch (Throwable $e) {
            \Log::error('Category store failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to create category!');
        }
    }

    public function show(int|string $id)
    {
        $category = Category::where('user_id', auth()->id())
            ->findOrFail($id);
        if (!$category) {
            return back()->with('error', 'Category Not Found');
        }

        return view('user.categories.show', compact('category'));
    }

    public function edit(int|string $id) : View {
        $category = Category::where('user_id', auth()->id())
            ->findOrFail($id);

        if (!$category) {
            return back()->with('error', 'Category Not Found');
        }

        return view('categories.edit', [
            'category' => $category,
            'updateUrl' => route('user.categories.update', $category->id)
        ]);
    }

    public function update(CategoryUpdateRequest $request, int|string $id) 
    {
        try {
            $category = Category::where('user_id', auth()->id())
                ->findOrFail($id);
            if (!$category) {
                return back()->with('error', 'Category Not Found');
            }

            $data = $request->validated();
            $this->service->update($id, $data);

            return back()->with('success', 'Category updated successfully!');

        } catch (Throwable $e) {
            \Log::error('Category update failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to update category!');
        }
    }


    public function destroy(int|string $id) 
    {
        try {
            $category = Category::where('user_id', auth()->id())
                ->findOrFail($id);
            if (!$category) {
                return back()->with('error', 'Category Not Found');
            }

            $this->service->delete($id);

            return redirect()->route('user.categories.mine')->with('success', 'Category deleted successfully!');

        } catch (Throwable $e) {
            \Log::error('Category delete failed', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', $e->getMessage());
        }
    }
}