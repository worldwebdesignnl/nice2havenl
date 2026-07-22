<?php

use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Store;
use App\Models\UspBlock;

test('the homepage returns a successful response', function () {
    Store::factory()->create();
    Category::factory()->create();
    HeroSlide::factory()->create();
    UspBlock::factory()->create();

    $response = $this->get('/');

    $response->assertStatus(200);
});
