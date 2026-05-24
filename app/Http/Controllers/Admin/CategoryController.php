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
                'color',
                'is_active',
                'created_at'
            )->with('user:id,name');

            return datatables()
                ->of($categories)
                ->editColumn('color', function ($category) {
                    return '<span class="badge badge-pill" style="background-color: ' . $category->color . ';">&nbsp;&nbsp;</span>';
                })
                ->editColumn('is_active', function ($category) {
                    return $category->is_active ? 'True' : '-';
                })
                ->editColumn('created_at', function ($category) {
                    return $category->created_at->format('Y-m-d h:i');
                })
                ->addIndexColumn()
                ->rawColumns(['color'])
                ->make(true);
        }

        return view('categories.index', [
            'ajaxUrl' => route('admin.categories.index')
        ]);
    }

    public function getSystemCategory(Request $request)
    {
        if($request->ajax()) {
            $categories = $this->service->getSystemCategories();

            return datatables()
                ->of($categories)
                ->addColumn('toggle-status', function ($category) {

                    $checked = $category->is_active ? 'checked' : '';

                    return '
                        <div class="custom-control custom-switch custom-switch-on-success">
                            <input
                                type="checkbox"
                                class="custom-control-input toggle-status"
                                id="switch-' . $category->id . '"
                                data-id="' . $category->id . '"
                                ' . $checked . '
                            >

                            <label
                                class="custom-control-label"
                                for="switch-' . $category->id . '">
                            </label>
                        </div>
                    ';
                })
                ->editColumn('color', function ($category) {
                    return '<span class="badge badge-pill" style="background-color: ' . $category->color . ';">&nbsp;&nbsp;</span>';
                })
                ->editColumn('is_active', function ($category) {
                    return $category->is_active ? 'True' : '-';
                })
                ->editColumn('created_at', function ($category) {
                    return $category->created_at->format('Y M d h:i');
                })
                ->addColumn('actions', function ($category) {
                    $editUrl = route('admin.categories.edit', $category->id);
                    $deleteUrl = route('admin.categories.destroy', $category->id);

                    $btn = '<a href="' . $editUrl . '" class="btn btn-sm btn-primary mr-2">Edit</a>';
                    $btn .= '<form action="'
                        . $deleteUrl
                        . '" method="post" style="display:inline-block">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';
                    return $btn;
                })
                ->rawColumns(['toggle-status', 'color', 'actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('categories.mine', [
            'ajaxUrl' => route('admin.categories.system'),
            'createUrl' => route('admin.categories.create')
        ]);
    }

    public function getMine() {
        $categories = $this->service->getMine();

        return view('categories.index', compact('categories'));
    }

    public function create(): View 
    {
        return view('categories.create',[
            'storeUrl' => route('admin.categories.store'),
            'backUrl' => route('admin.categories.system')

        ]);
    }

    public function store(CategoryStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = auth()->id();

            $this->service->create($data);

            return redirect()->route('admin.categories.mine')->with('status', 'Category created successfully!');

        } catch (\Throwable $e) {
            \Log::error('Category store failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to create category!');
        }
    }

    public function edit(int|string $id) 
    {
        $category = $this->service->find($id);

        if(!$category) {
            return redirect()->route('admin.categories.mine')->with('error', 'Category Not Found!');
        }

        return view('categories.edit', [
            'category' => $category,
            'updateUrl' => route('admin.categories.update', $category->id),
            'backUrl' => route('admin.categories.system')
        ]);
    }

    public function update(CategoryUpdateRequest $request, int|string $id) 
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

            return redirect()->route('admin.categories.mine')->with('status', 'Category updated successfully!');

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

            return redirect()->route('admin.categories.mine')->with('status', 'Category deleted successfully!');
            
        } catch (\Throwable $e) {
            \Log::error('Category delete failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to delete category.');
        }
    }

    
}
