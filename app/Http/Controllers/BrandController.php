<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function index(): View
    {
        return view('brands.index', [
            'brands' => Brand::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function show(Brand $brand): View
    {
        return view('brands.show', [
            'brand' => $brand,
            'products' => $brand->products()->active()->orderBy('sort_order')->get(),
        ]);
    }
}
