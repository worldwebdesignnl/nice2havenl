<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        return view('products.show', [
            'product' => $product->load('brand', 'categories'),
            'related' => Product::active()
                ->whereKeyNot($product->id)
                ->whereHas('categories', fn ($query) => $query->whereIn('categories.id', $product->categories->pluck('id')))
                ->limit(4)
                ->get(),
        ]);
    }
}
