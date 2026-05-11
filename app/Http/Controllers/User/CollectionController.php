<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionStoreRequest;
use App\Models\Category;
use App\Models\Collection;
use App\Services\CategoryService;
use App\Services\CollectionService;
use Illuminate\Http\Request;
use Throwable;

class CollectionController extends Controller
{
    protected CollectionService $collectionService;
    protected CategoryService $categoryService;

    public function __construct(CollectionService $collectionService, CategoryService $categoryService) 
    {
        $this->collectionService = $collectionService;
        $this->categoryService = $categoryService;
    }
    
    public function index(Request $request) 
    {
        if ($request->ajax()) {

            $collections = Collection::where('user_id', auth()->id())
                ->select('id', 'name', 'description', 'created_at', 'updated_at');

            return datatables()
                ->of($collections)
                ->editColumn('created_at', function ($collection) {
                    return optional($collection->created_at)->format('Y-m-d h:i');
                })
                ->editColumn('updated_at', function ($collection) {
                    return optional($collection->updated_at)->format('Y-m-d h:i');
                })
                ->addColumn('actions', function ($collection) {
                    $viewUrl = route('collections.show', $collection->id);
                    $editUrl = route('collections.edit', $collection->id);
                    $deleteUrl = route('collections.destroy', $collection->id);

                $btn = '<div class="btn-group" role="group">'
                        . '<a href="' . $viewUrl . '" class="btn btn-sm btn-info mr-1 rounded-sm">View</a>'
                        . '<a href="' . $editUrl . '" class="btn btn-sm btn-primary mr-1 rounded-sm">Edit</a>';
                $btn .= '<form action="' . $deleteUrl . '" method="post" style="display: inline-block;">'
                        . csrf_field()
                        . method_field('DELETE')
                        . '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>'
                        . '</form> </div>';

                    return $btn;
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('collections.index');
    }

    public function show(int| string $id) 
    {
        $collection = $this->collectionService->find($id);
        return view('collections.show', compact('collection'));
    }

    public function create()
    {
        $categories = Category::whereIn('user_id', [auth()->id()])->get();
        return view('collections.create', compact('categories'));
    }

    public function store(CollectionStoreRequest $request) 
    {
        try {
            $data = $request->validated();

            $data['user_id'] = auth()->id();
            $this->collectionService->create($data);

            return redirect()->route('collections.index')->with('success', 'Collection created successfully!');

        } catch (Throwable $e) {
            \Log::error('Category store failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to create category!');
        }        
    }

    public function edit(int|string $id)
    {
        $exists = $this->collectionService->exists(['user_id' => auth()->id(), 'id' => $id]);

        if (!$exists) {
            return back()->withInput()->with('error', 'Collection not found!');
        }

        $collection = Collection::with('categories')->find($id);
        $categories = Category::whereIn('user_id', [auth()->id()])->get();
        return view('collections.edit', compact('collection', 'categories'));
    }

    public function update(CollectionStoreRequest $request, int|string $id) 
    {
        try {
            $exists = $this->collectionService->exists(['user_id' => auth()->id(), 'id' => $id]);

            if (!$exists) {
                return back()->withInput()->with('error', 'Collection not found!');
            }

            $data = $request->validated();
            $this->collectionService->update($id, $data);

            return redirect()->route('collections.index')->with('success', 'Collection updated successfully!');
            
        } catch (Throwable $e) {
            \Log::error('Category store failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to create category!');
        }

    }

    public function destroy(int|string $id) 
    {
        try {
            $exists = $this->collectionService->exists(['user_id' => auth()->id(), 'id' => $id]);

            if (!$exists) {
                return back()->withInput()->with('error', 'Collection not found!');
            }

            $this->collectionService->delete($id);

            return redirect()->route('collections.index')->with('success', 'Collection deleted successfully!');

        } catch (Throwable $e) {
            \Log::error('Category store failed', [
                'error' => $e->getMessage()
            ]);

            return back()->withInput()->with('error', 'Failed to create category!');
        }
    }

    public function costs(int|string $id)
    {
        $collection = $this->collectionService->find($id);

        if (!$collection || $collection->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Collection not found or access denied!'
            ], 403);
        }

        $costs = $collection->costs()
            ->with('category:id,name,color')
            ->latest()
            ->get()
            ->map(function ($cost) {
                return [
                    'id' => $cost->id,
                    'name' => $cost->name,
                    'price' => $cost->price,
                    'category' => $cost->category->name ?? null,
                    'categoryColor' => $cost->category->color ?? null,
                    'actions' => '',
                ];
            });

        return response()->json([
            'data' => $costs
        ]);
    }
}
