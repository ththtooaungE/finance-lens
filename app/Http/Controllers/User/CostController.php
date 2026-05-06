<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CostStoreRequest;
use App\Http\Requests\CostUpdateRequest;
use App\Services\CostService;

class CostController extends Controller
{
    protected CostService $service;

    public function __construct(CostService $service)
    {
        $this->service = $service;
    }

    public function store(CostStoreRequest $request)
    {
        try {
            if ($request->collection_id) {
                $collection = $this->service->findCollectionById($request->collection_id);

                if (!$collection || $collection->user_id !== auth()->id()) {
                    return back()->withInput()->with('error', 'Collection not found or access denied!');
                }
            }

            if ($request->category_id) {
                $category = $this->service->findCategoryById($request->category_id);

                if (!$category || ($category->user_id !== auth()->id() && $category->user_id !== 1)) {
                    return back()->withInput()->with('error', 'Category not found or access denied!');
                }
            }

            $data = $request->validated();
            $this->service->create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Cost created successfully!'
            ], 201);
        } catch (\Throwable $e) {
            \Log::error('Cost store failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create cost!'
            ], 500);
        }
    }

    public function update(CostUpdateRequest $request, int|string $id)
    {
        try {
            $data = $request->validated();
            $this->service->update($id, $data);

            return response()->json([
                'status' => 'success',
                'message' => 'Cost updated successfully!'
            ], 201);

        } catch (\Throwable $e) {
            \Log::error('Cost update failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update cost!'
            ], 500);
        }
    }

    public function delete(int|string $id)
    {
        try {
            $cost = $this->service->findCollectionByCostId($id);

            if(!$cost || $cost->user_id !== auth()->id()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cost not found or access denied!'
                ], 404);
            }

            $this->service->delete($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Cost deleted successfully!'
            ], 200);

        } catch (\Throwable $e) {
            \Log::error('Cost delete failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete cost!'
            ], 500);
        }
    }
}
