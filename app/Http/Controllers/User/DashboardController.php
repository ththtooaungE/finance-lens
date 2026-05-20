<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        /*
    |--------------------------------------------------------------------------
    | Dashboard Counters
    |--------------------------------------------------------------------------
    */

        $categoryCount = Category::where('user_id', $userId)->count();

        $collectionCount = Collection::where('user_id', $userId)->count();

        $recentCollections = Collection::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Report 1
    | Latest Collection Category Breakdown
    |--------------------------------------------------------------------------
    */

        $latestCollectionByCategory = Collection::where('user_id', $userId)
            ->latest()
            ->with([
                'costs' => function ($query) {

                    $query->selectRaw('
                        collection_id,
                        category_id,
                        SUM(price) as total
                    ')
                        ->groupBy('collection_id', 'category_id')
                        ->with('category');
                }
            ])
            ->first();

        $latestCollectionCategoryReport = [
            'labels' => [],
            'data' => [],
            'colors' => [],
        ];

        if ($latestCollectionByCategory) {

            $latestCollectionCategoryReport['labels'] = $latestCollectionByCategory->costs
                ->map(fn($cost) => $cost->category->name)
                ->toArray();

            $latestCollectionCategoryReport['colors'] = $latestCollectionByCategory->costs
                ->map(fn($cost) => $cost->category->color)
                ->toArray();

            $latestCollectionCategoryReport['data'] = $latestCollectionByCategory->costs
                ->map(fn($cost) => $cost->total)
                ->toArray();
        }
        /*
    |--------------------------------------------------------------------------
    | Report 2
    | Latest Collection Date Breakdown
    |--------------------------------------------------------------------------
    */
        $latestCollectionByDate = Collection::where('user_id', $userId)
            ->latest()
            ->first();

        $latestCollectionDateReport = [
            'labels' => [],
            'data' => [],
        ];

        if ($latestCollectionByDate) {

            $dailyCosts = $latestCollectionByDate->costs()
                ->selectRaw('
                DATE(created_at) as date,
                SUM(price) as total
            ')
                ->groupByRaw('DATE(created_at)')
                ->orderBy('date')
                ->get();

            $latestCollectionDateReport['labels'] = $dailyCosts
                ->pluck('date')
                ->toArray();

            $latestCollectionDateReport['data'] = $dailyCosts
                ->pluck('total')
                ->toArray();
        }


        /*
    |--------------------------------------------------------------------------
    | Report 3
    | Previous Collection Daily Spending
    |--------------------------------------------------------------------------
    */

        $previousCollectionByCategory = Collection::where('user_id', $userId)
            ->latest()
            ->skip(1)
            ->with([
                'costs' => function ($query) {

                    $query->selectRaw('
                        collection_id,
                        category_id,
                        SUM(price) as total
                    ')
                        ->groupBy('collection_id', 'category_id')
                        ->with('category');
                }
            ])
            ->first();

        $previousCollectionCategoryReport = [
            'labels' => [],
            'data' => [],
            'colors' => [],
        ];

        if ($previousCollectionByCategory) {

            $previousCollectionCategoryReport['labels'] = $previousCollectionByCategory->costs
                ->map(fn($cost) => $cost->category->name)
                ->toArray();

            $previousCollectionCategoryReport['colors'] = $previousCollectionByCategory->costs
                ->map(fn($cost) => $cost->category->color)
                ->toArray();

            $previousCollectionCategoryReport['data'] = $previousCollectionByCategory->costs
                ->map(fn($cost) => $cost->total)
                ->toArray();
        }
        /*
    |--------------------------------------------------------------------------
    | Report 4
    | Latest Collection Date Breakdown
    |--------------------------------------------------------------------------
    */
        $previousCollectionByDate = Collection::where('user_id', $userId)
            ->latest()
            ->skip(1)
            ->first();

        $previousCollectionDateReport = [
            'labels' => [],
            'data' => [],
        ];

        if ($previousCollectionByDate) {

            $dailyCosts = $previousCollectionByDate->costs()
                ->selectRaw('
                DATE(created_at) as date,
                SUM(price) as total
            ')
                ->groupByRaw('DATE(created_at)')
                ->orderBy('date')
                ->get();

            $previousCollectionDateReport['labels'] = $dailyCosts
                ->pluck('date')
                ->toArray();

            $previousCollectionDateReport['data'] = $dailyCosts
                ->pluck('total')
                ->toArray();
        }

        /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

        return view('dashboard', [

            'categoryCount' => $categoryCount,

            'collectionCount' => $collectionCount,

            'recentCollections' => $recentCollections,

            'latestCollectionCategoryReport' => $latestCollectionCategoryReport,

            'latestCollectionDateReport' => $latestCollectionDateReport,

            'previousCollectionCategoryReport' => $previousCollectionCategoryReport,

            'previousCollectionDateReport' => $previousCollectionDateReport,
        ]);
    }
}
