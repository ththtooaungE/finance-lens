<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class BuildMenu
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BuildingMenu $event): void
    {
        $user = Auth::user();

        if (!$user) {
            return;
        }

        $latestCollections = $user->collections()
            ->latest()
            ->take(3)
            ->get()
            ->reverse();

        foreach ($latestCollections as $collection) {
            $event->menu->addAfter('collections-menu', [
                'text' => Str::limit($collection->name, 20),
                'icon' => 'far fa-fw fa-file',
                'icon_color' => 'grey',
                'url' => '/collections/' . $collection->id,
            ]);
        }
    }
}
