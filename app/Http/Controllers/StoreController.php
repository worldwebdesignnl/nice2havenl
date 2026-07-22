<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\View\View;

class StoreController extends Controller
{
    public function show(Store $store): View
    {
        return view('stores.show', [
            'store' => $store->load('openingHours'),
            'otherStores' => Store::query()->with('openingHours')->where('is_active', true)->whereKeyNot($store->id)->get(),
        ]);
    }
}
