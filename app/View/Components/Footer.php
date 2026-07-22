<?php

namespace App\View\Components;

use App\Models\MenuItem;
use App\Models\SchemaSetting;
use App\Models\Store;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Footer extends Component
{
    public $items;

    public $stores;

    public $organization;

    public function __construct()
    {
        $this->items = MenuItem::location('footer')
            ->topLevel()
            ->active()
            ->orderBy('sort_order')
            ->get();

        $this->stores = Store::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $this->organization = SchemaSetting::get('organization', []);
    }

    public function render(): View|Closure|string
    {
        return view('components.footer');
    }
}
