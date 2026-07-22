<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\StoreController;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Store;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', HomeController::class)->name('home');

Route::get('/categorie/{category:slug}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/merken', [BrandController::class, 'index'])->name('brand.index');
Route::get('/merken/{brand:slug}', [BrandController::class, 'show'])->name('brand.show');

Route::get('/winkel/{store:slug}', [StoreController::class, 'show'])->name('store.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware([ProtectAgainstSpam::class, 'throttle:5,1'])
    ->name('contact.store');

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create(route('home'))->setPriority(1.0))
        ->add(Url::create(route('brand.index'))->setPriority(0.6))
        ->add(Url::create(route('contact.index'))->setPriority(0.5));

    Category::query()->where('is_active', true)->each(
        fn (Category $category) => $sitemap->add(Url::create(route('category.show', $category->slug))->setPriority(0.8))
    );

    Brand::query()->where('is_active', true)->each(
        fn (Brand $brand) => $sitemap->add(Url::create(route('brand.show', $brand->slug))->setPriority(0.6))
    );

    Store::query()->where('is_active', true)->each(
        fn (Store $store) => $sitemap->add(Url::create(route('store.show', $store->slug))->setPriority(0.9))
    );

    Page::published()->each(
        fn (Page $page) => $sitemap->add(Url::create(route('page.show', $page->slug))->setPriority(0.4))
    );

    return $sitemap->toResponse(request());
})->name('sitemap');

// Catch-all CMS route — must stay last so it never shadows the routes above.
Route::get('/{page:slug}', [PageController::class, 'show'])->name('page.show');
