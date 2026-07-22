<?php

namespace App\View\Components;

use App\Models\MenuItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Nav extends Component
{
    public $items;

    public function __construct()
    {
        $this->items = MenuItem::location('top')
            ->topLevel()
            ->active()
            ->with('children')
            ->orderBy('sort_order')
            ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.nav');
    }
}
