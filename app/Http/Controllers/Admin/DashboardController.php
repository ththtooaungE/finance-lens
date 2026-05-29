<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    function index()
    {
        $categoryCount = \App\Models\Category::count();
        $userCount = \App\Models\User::count();
        $collectionCount = \App\Models\Collection::count();

        $monthlyUsers = \App\Models\User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $monthlyUserReport['labels'] = $monthlyUsers->pluck('month')->map(function($month) {
            return date('F', mktime(0, 0, 0, $month, 10));
        });
        $monthlyUserReport['data'] = $monthlyUsers->pluck('count')->toArray();


        $usersWithMostCollectins = \App\Models\User::with('collections')
            ->withCount('collections')
            ->orderBy('collections_count', 'desc')
            ->where('role', 'user')
            ->take(5)
            ->get();
        $monthlyMostCollectionUserReport['labels'] = $usersWithMostCollectins->pluck('name')->toArray();
        $monthlyMostCollectionUserReport['data'] = $usersWithMostCollectins->pluck('collections_count')->toArray();
        
        return view('admin.dashboard.dashboard', [
            'categoryCount' => $categoryCount,
            'userCount' => $userCount,
            'collectionCount' => $collectionCount,
            'monthlyUserReport' => $monthlyUserReport,
            'monthlyMostCollectionUserReport' => $monthlyMostCollectionUserReport,
        ]);
    }
}
