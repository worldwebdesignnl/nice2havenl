<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Store;
use App\Models\UspBlock;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'slides' => HeroSlide::active()->get(),
            'uspBlocks' => UspBlock::active()->get(),
            'categories' => Category::topLevel()->active()->orderBy('sort_order')->get(),
            'stores' => Store::query()->with('openingHours')->where('is_active', true)->orderBy('sort_order')->get(),
            'brands' => Brand::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
