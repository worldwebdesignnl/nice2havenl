<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        $products = $category->products()
            ->active()
            ->with('brand')
            ->orderBy('sort_order')
            ->get();

        return view('categories.show', [
            'category' => $category,
            'products' => $products,
            'brands' => $products->pluck('brand')->unique('id')->values(),
        ]);
    }
}
