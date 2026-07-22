<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\MenuItem;
use App\Models\OpeningHour;
use App\Models\Page;
use App\Models\Product;
use App\Models\SchemaSetting;
use App\Models\Store;
use App\Models\UspBlock;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Nice2Have Beheer',
            'email' => 'admin@nice-2-have.nl',
            'password' => bcrypt('password'),
        ]);

        $stores = $this->seedStores();
        $categories = $this->seedCategories();
        $brands = $this->seedBrands();
        $this->seedProducts($brands, $categories);
        $this->seedHeroSlides();
        $this->seedUspBlocks();
        $pages = $this->seedPages();
        $this->seedMenus($categories, $stores, $pages);
        $this->seedSchemaSettings();
    }

    private function seedStores(): array
    {
        $heerhugowaard = Store::create([
            'name' => 'Heerhugowaard',
            'address_line' => 'Raadhuisplein 8',
            'postal_code' => '1701 EA',
            'city' => 'Heerhugowaard',
            'phone' => '072-5711234',
            'email' => 'heerhugowaard@nice-2-have.nl',
            'shopping_center' => 'Winkelcentrum Centrumwaard',
            'description' => 'In winkelcentrum Centrumwaard, met het volledige assortiment onder één dak.',
            'latitude' => 52.6698,
            'longitude' => 4.8352,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $castricum = Store::create([
            'name' => 'Castricum',
            'address_line' => 'Geesterduin 50',
            'postal_code' => '1901 JD',
            'city' => 'Castricum',
            'phone' => '0251-651234',
            'email' => 'castricum@nice-2-have.nl',
            'shopping_center' => 'Winkelcentrum Geesterduin',
            'description' => 'In winkelcentrum Geesterduin, met een ruim en licht winkelpand.',
            'latitude' => 52.5464,
            'longitude' => 4.6867,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $weekSchedule = [
            0 => ['opens' => '11:00', 'closes' => '17:30'], // maandag
            1 => ['opens' => '09:30', 'closes' => '17:30'], // dinsdag
            2 => ['opens' => '09:30', 'closes' => '17:30'], // woensdag
            3 => ['opens' => '09:30', 'closes' => '17:30'], // donderdag
            4 => ['opens' => '09:30', 'closes' => '18:00'], // vrijdag
            5 => ['opens' => '09:30', 'closes' => '17:00'], // zaterdag
        ];

        foreach ([$heerhugowaard, $castricum] as $store) {
            foreach ($weekSchedule as $day => $hours) {
                OpeningHour::create([
                    'store_id' => $store->id,
                    'day_of_week' => $day,
                    'opens_at' => $hours['opens'],
                    'closes_at' => $hours['closes'],
                    'is_closed' => false,
                ]);
            }
            OpeningHour::create([
                'store_id' => $store->id,
                'day_of_week' => 6,
                'opens_at' => null,
                'closes_at' => null,
                'is_closed' => true,
            ]);
        }

        return ['heerhugowaard' => $heerhugowaard, 'castricum' => $castricum];
    }

    private function seedCategories(): array
    {
        $definitions = [
            ['name' => 'Tassen', 'slug' => 'tassen', 'icon' => 'bi-bag-fill'],
            ['name' => 'Sieraden', 'slug' => 'sieraden', 'icon' => 'bi-gem'],
            ['name' => 'Horloges', 'slug' => 'horloges', 'icon' => 'bi-smartwatch'],
            ['name' => 'Riemen & Sjaals', 'slug' => 'riemen-sjaals', 'icon' => 'bi-tags-fill'],
        ];

        $categories = [];
        foreach ($definitions as $i => $definition) {
            $categories[$definition['slug']] = Category::create([
                'name' => $definition['name'],
                'slug' => $definition['slug'],
                'icon' => $definition['icon'],
                'description' => "Ons assortiment {$definition['name']} wisselt continu — kom langs in de winkel om te zien, voelen en passen.",
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);
        }

        return $categories;
    }

    private function seedBrands(): array
    {
        $definitions = [
            'josh' => ['name' => 'Josh', 'description' => 'Betaalbare, trendgevoelige tassen en accessoires.'],
            'qoss' => ['name' => 'Qoss', 'description' => 'Hippe tassen met een vleugje bohemien.'],
            'micmac' => ['name' => 'Micmac Bags', 'description' => 'Kleurrijke, handgemaakte tassen.'],
            'cluse' => ['name' => 'Cluse', 'description' => 'Minimalistische horloges uit Nederland.'],
            'oozoo' => ['name' => 'Oozoo', 'description' => 'Betaalbare horloges met een uitgesproken statement-look.'],
            'ixxxi' => ['name' => 'ixxxi', 'description' => 'Modulaire sieraden om zelf mee te combineren.'],
            'karma' => ['name' => 'Karma', 'description' => 'Sieraden met een verhaal, van natuurlijke materialen.'],
            'uno-de-50' => ['name' => 'Uno de 50', 'description' => 'Handgemaakte sieraden uit Spanje, verzilverd.'],
            'ikki' => ['name' => 'Ikki', 'description' => 'Kleurrijke, verstelbare sieraden.'],
            'biba' => ['name' => 'Biba', 'description' => 'Klassieke sieraden met een moderne twist.'],
            'melano' => ['name' => 'Melano', 'description' => 'Bouw je eigen sieraad met verwisselbare stones.'],
        ];

        $brands = [];
        foreach ($definitions as $slug => $definition) {
            $brands[$slug] = Brand::create([
                'name' => $definition['name'],
                'slug' => $slug,
                'description' => $definition['description'],
                'is_active' => true,
            ]);
        }

        return $brands;
    }

    private function seedProducts(array $brands, array $categories): void
    {
        $definitions = [
            ['brand' => 'josh', 'category' => 'tassen', 'name' => 'Josh Schoudertas Leer', 'price' => 89.95],
            ['brand' => 'qoss', 'category' => 'tassen', 'name' => 'Qoss Crossbody Bohemian', 'price' => 69.95],
            ['brand' => 'micmac', 'category' => 'tassen', 'name' => 'Micmac Weekendtas Gekleurd', 'price' => 99.95],
            ['brand' => 'ixxxi', 'category' => 'sieraden', 'name' => 'ixxxi Ring Set Basis', 'price' => 24.95],
            ['brand' => 'ixxxi', 'category' => 'sieraden', 'name' => 'ixxxi Ketting Munten', 'price' => 34.95],
            ['brand' => 'ixxxi', 'category' => 'sieraden', 'name' => 'ixxxi Armband Stapelset', 'price' => 29.95],
            ['brand' => 'cluse', 'category' => 'horloges', 'name' => 'Cluse Minuit Rosé', 'price' => 119.00],
            ['brand' => 'oozoo', 'category' => 'horloges', 'name' => 'Oozoo Timepieces XL', 'price' => 59.95],
            ['brand' => 'cluse', 'category' => 'horloges', 'name' => 'Cluse La Bohème Zwart', 'price' => 109.00],
            ['brand' => 'josh', 'category' => 'riemen-sjaals', 'name' => 'Josh Sjaal Wintercollectie', 'price' => 29.95],
            ['brand' => 'qoss', 'category' => 'riemen-sjaals', 'name' => 'Qoss Riem Suède', 'price' => 39.95],
            ['brand' => 'micmac', 'category' => 'riemen-sjaals', 'name' => 'Micmac Sjaal Gekleurd Print', 'price' => 24.95],
        ];

        foreach ($definitions as $i => $definition) {
            $product = Product::create([
                'brand_id' => $brands[$definition['brand']]->id,
                'name' => $definition['name'],
                'short_description' => "Nieuw binnen bij Nice2Have: {$definition['name']}.",
                'price' => $definition['price'],
                'price_label' => 'vanaf',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => $i + 1,
            ]);

            $product->categories()->attach($categories[$definition['category']]->id);
        }
    }

    private function seedHeroSlides(): void
    {
        $slides = [
            ['kicker' => 'Nieuwe collectie', 'title' => 'Trendy tassen voor elk moment', 'subtitle' => "Van ruime shoppers tot elegante crossbody's. Ontdek de nieuwste tassen van Josh, Qoss en Micmac Bags.", 'button_label' => 'Bekijk tassen', 'button_url' => '/categorie/tassen'],
            ['kicker' => 'Toonaangevende merken', 'title' => 'Hip & betaalbaar, elke week anders', 'subtitle' => 'Cluse, Oozoo, ixxxi en nog veel meer — ons assortiment wisselt continu.', 'button_label' => 'Bekijk merken', 'button_url' => '/merken'],
            ['kicker' => 'Twee winkels, één stijl', 'title' => 'Altijd een Nice2Have in de buurt', 'subtitle' => 'Winkelcentrum Centrumwaard in Heerhugowaard en winkelcentrum Geesterduin in Castricum.', 'button_label' => 'Bekijk onze winkels', 'button_url' => '/#winkels'],
        ];

        foreach ($slides as $i => $slide) {
            HeroSlide::create([...$slide, 'sort_order' => $i + 1, 'is_active' => true]);
        }
    }

    private function seedUspBlocks(): void
    {
        $blocks = [
            ['icon' => 'bi-shop', 'title' => 'Twee winkels', 'text' => 'Heerhugowaard en Castricum, allebei met een eigen sfeer en assortiment.'],
            ['icon' => 'bi-award', 'title' => 'Toonaangevende merken', 'text' => 'Een zorgvuldig samengestelde selectie van merken die je overal ziet terugkomen.'],
            ['icon' => 'bi-heart', 'title' => 'Hip & betaalbaar', 'text' => 'Trendgevoelige items zonder dat het je een fortuin kost.'],
        ];

        foreach ($blocks as $i => $block) {
            UspBlock::create([...$block, 'sort_order' => $i + 1, 'is_active' => true]);
        }
    }

    private function seedPages(): array
    {
        $overOns = Page::create([
            'title' => 'Over ons',
            'body' => '<p>Nice2Have is een trendjuwelier en conceptstore met twee winkels: Heerhugowaard en Castricum. Ons assortiment wisselt continu, dus kom vooral eens langs.</p>',
            'is_published' => true,
            'published_at' => now(),
        ]);

        return ['over-ons' => $overOns];
    }

    private function seedMenus(array $categories, array $stores, array $pages): void
    {
        $top = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Tassen', 'linkable' => $categories['tassen']],
            ['label' => 'Sieraden', 'linkable' => $categories['sieraden']],
            ['label' => 'Horloges', 'linkable' => $categories['horloges']],
            ['label' => 'Riemen & Sjaals', 'linkable' => $categories['riemen-sjaals']],
            ['label' => 'Merken', 'url' => '/merken'],
            ['label' => 'Contact', 'url' => '/contact'],
        ];

        foreach ($top as $i => $item) {
            MenuItem::create([
                'location' => 'top',
                'label' => $item['label'],
                'url' => $item['url'] ?? null,
                'linkable_type' => isset($item['linkable']) ? get_class($item['linkable']) : null,
                'linkable_id' => $item['linkable']->id ?? null,
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }

        $footer = [
            ['label' => 'Winkel Heerhugowaard', 'linkable' => $stores['heerhugowaard']],
            ['label' => 'Winkel Castricum', 'linkable' => $stores['castricum']],
            ['label' => 'Over ons', 'linkable' => $pages['over-ons']],
            ['label' => 'Contact', 'url' => '/contact'],
        ];

        foreach ($footer as $i => $item) {
            MenuItem::create([
                'location' => 'footer',
                'label' => $item['label'],
                'url' => $item['url'] ?? null,
                'linkable_type' => isset($item['linkable']) ? get_class($item['linkable']) : null,
                'linkable_id' => $item['linkable']->id ?? null,
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedSchemaSettings(): void
    {
        SchemaSetting::create([
            'key' => 'organization',
            'value' => [
                'name' => 'Nice2Have',
                'email' => 'info@nice-2-have.nl',
                'instagram_url' => 'https://www.instagram.com/nice2have',
                'facebook_url' => 'https://www.facebook.com/nice2have',
            ],
            'is_active' => true,
        ]);
    }
}
