# Technisch Bouwplan — Nice2Have (Laravel)

**Project:** nice-2-have.nl
**Framework:** Laravel (PHP)
**Opdrachtgever/bouw:** Worldwebdesign (Bob Kool, Heerhugowaard)
**Datum:** juli 2026
**Status:** Basisimplementatie (fase 1), op basis van het bestaande HTML-prototype

---

## 1. Doel en uitgangspunten

Nice2Have — trendjuwelier en conceptstore met twee fysieke winkels in Heerhugowaard en Castricum — krijgt een op maat gebouwde website in Laravel. De site toont de collectie (tassen, sieraden, horloges, riemen & sjaals) per categorie en merk, presenteert beide winkels met adres, openingstijden en route, en biedt een contactformulier. Er is nadrukkelijk **geen webshop**: het prototype stelt expliciet "Zien, voelen en passen doe je in de winkel" — de site is een etalage die naar de fysieke winkel converteert, geen verkooppunt.

Uitgangspunt is het bestaande HTML-prototype (`index.html`, `tassen.html`, `contact.html`, `heerhugowaard.html`, `castricum.html`) als visuele en functionele referentie: Bootstrap 5-opbouw, het "editorial"-kleurenpalet (rose `#bd8f6e`, dark `#141414`, cream `#faf8f5`), de lettertypes Space Grotesk/Jost, de cinematische hero-slider en de kaart- en productkaart-componenten. Dezelfde componentopbouw wordt in Laravel Blade-componenten gegoten, met de content (winkels, merken, categorieën, producten, pagina's, menu's) volledig beheerbaar via een admin-panel.

Scope fase 1: een werkende site met beheerbare content, twee winkellocaties, een lichte productcatalogus (uitgelichte producten per categorie, geen voorraadbeheer) en een contactformulier. Uitbreidingen (webshop/bestellen, voorraad, klantaccounts, cadeaubon online verkopen) zijn expliciet buiten scope maar niet uitgesloten in het datamodel.

---

## 2. Technische stack

| Onderdeel | Keuze | Toelichting |
|---|---|---|
| Backend | Laravel (laatste LTS-geschikte release) | MVC, Eloquent ORM, migrations, queue, mail |
| Database | MySQL 8 / MariaDB | Relationele opslag winkels, catalogus + content |
| Admin/CMS | Filament (aanbevolen) | Snel, uitbreidbaar admin-panel op Eloquent |
| Frontend | Blade + Bootstrap 5.3 | Sluit aan op bestaand ontwerp/prototype |
| Assets | Vite | Bundling CSS/JS |
| Media | Spatie MediaLibrary | Foto's per product, winkel en homepage-slide |
| Slugs | Spatie Sluggable | SEO-vriendelijke URL's (o.a. `/tassen`, `/heerhugowaard`) |
| SEO/schema | Eigen `SchemaService` + config | JSON-LD generatie, o.a. meerdere `LocalBusiness`-locaties |
| Sitemap | Spatie Sitemap | Automatische sitemap.xml |
| Kaarten | Google Maps Embed / Static Maps API | Route en kaart per winkel (vervangt de `map-placeholder` uit het prototype) |
| Formulieren | Laravel Form Requests + Mailable | Validatie + verzending, optioneel per winkel |
| Spam | Honeypot + rate limiting | Eenvoudige bescherming contactformulier |

Aanbeveling: **Filament** als admin-panel, om dezelfde reden als bij eerdere Worldwebdesign-projecten: snelle CRUD, media-uploads en formulieropbouw out-of-the-box.

---

## 3. Functionele scope (fase 1)

Afgeleid van het bestaande prototype (`index.html`, `tassen.html`, `contact.html`, `heerhugowaard.html`, `castricum.html`):

**Content Management**
- CMS voor het toevoegen en beheren van (losse) pagina's.
- Menu-beheer voor topmenu en footermenu (beheerbare links en volgorde) — nu nog hardgecodeerd (`Home, Tassen, Sieraden, Horloges, Riemen & Sjaals, Merken, Contact`).
- Beheerbare homepage-hero (cinematische slider met 2–3 slides: afbeelding, kicker, titel, subtekst, knop).
- Beheerbare USP-blokken op de homepage (nu: "Twee winkels", "Toonaangevende merken", "Hip & betaalbaar").

**Winkels (nieuw t.o.v. eerdere projecten)**
- Twee (uitbreidbaar naar meer) winkellocaties: Heerhugowaard (Raadhuisplein 8, winkelcentrum Centrumwaard) en Castricum (Geesterduin 50, winkelcentrum Geesterduin).
- Per winkel: naam, adres, telefoonnummer, openingstijden per dag, foto, korte beschrijving/USP's (bijv. "gratis parkeren", "volledig assortiment"), kaart/route.
- Eigen winkelpagina per locatie (vgl. `heerhugowaard.html` / `castricum.html`), met kruisverwijzing naar de andere vestiging.
- Winkel-overzicht op de homepage en in de footer.

**Producten, Merken & Categorieën**
- Categoriestructuur voor de vier hoofdcategorieën: Tassen, Sieraden, Horloges, Riemen & Sjaals (self-referencing, dus uitbreidbaar met subcategorieën zoals "Kettingen" of "Ringen" onder Sieraden).
- Merkenoverzicht met logo/naam en beschrijving (bijv. Josh, Qoss, Micmac bags voor tassen; Cluse, Oozoo voor horloges; ixxxi voor sieraden).
- Aparte merkpagina met beschrijving en gekoppelde producten (nu alleen als menu-item aanwezig, nog niet uitgewerkt: `/merken`).
- Productkaarten per categorie: foto, merk, naam, richtprijs. **Geen "in winkelwagen"/bestelknop** — nadrukkelijk showcase, geen verkoop.
- Duidelijke, beheerbare boodschap dat het assortiment continu wisselt en dat de kaarten een selectie tonen ("Ons assortiment wisselt continu...").
- Optioneel per categorie of merk: korte FAQ-blokken voor SEO (lichter dan bij een productcatalogus met vaste voorraad, omdat producten geen vaste beschikbaarheid hebben).

**Contact**
- Algemeen contactformulier (naam, telefoon, onderwerp, bericht) zoals in `contact.html`.
- Contactgegevens per winkel (telefoon, adres) + algemeen e-mailadres en social-media links (Instagram, Facebook).
- Eenvoudige formulierverzending (e-mail naar beheerder + bevestiging), met optionele winkelkeuze zodat een vraag naar de juiste vestiging kan worden gerouteerd.

---

## 4. Datamodel

Onderstaand het relationele model.

### 4.1 Entiteiten en relaties

- **Store** (winkel) — nieuwe kernentiteit t.o.v. eerdere projecten; heeft veel ContactSubmissions (optioneel), heeft Media (foto's).
- **Brand** (merk) — heeft veel Products, optioneel gekoppeld aan één of meer Categories (bijv. Cluse/Oozoo → Horloges).
- **Category** (categorie) — self-referencing boom: topcategorie ↔ subcategorieën (`parent_id`). Startset: Tassen, Sieraden, Horloges, Riemen & Sjaals.
- **Product** — behoort tot één Brand, gekoppeld aan één of meer Categories, heeft veel Media (foto's), optioneel Faqs. Geen voorraad-/prijsverplichting; `price` is indicatief ("vanaf").
- **Faq** — polymorf koppelbaar aan Product, Category of Page.
- **Page** — losse CMS-pagina.
- **MenuItem** — menu-links, gegroepeerd per locatie (top/footer), zelf-nestbaar.
- **ContactSubmission** — opgeslagen formulierinzending, optioneel gekoppeld aan een Store.
- **HeroSlide** — beheerbare slides voor de cinematische homepage-hero.
- **SchemaSetting** — configureerbare schema-/SEO-instellingen (o.a. per-winkel `LocalBusiness`-data).

Relatieoverzicht:

```
Store (Heerhugowaard, Castricum, ...)
  └──∞ Media   (winkelfoto's)

Brand 1───∞ Product ∞───∞ Category (parent_id → Category)
                 │
                 ├──∞ Media   (galerij, via Spatie MediaLibrary)
                 └──∞ Faq     (polymorf: faqable, optioneel)

Page (standalone)
MenuItem (location: top|footer, parent_id → MenuItem)
HeroSlide (sort_order, is_active)
ContactSubmission (store_id nullable, product_id nullable)
SchemaSetting (key/value config)
```

### 4.2 Migraties (kernvelden)

**stores** *(nieuw)*
```
id, name, slug (uniek),               // "heerhugowaard", "castricum"
address_line, postal_code, city,
phone, email (nullable),
shopping_center (nullable),            // "Centrumwaard", "Geesterduin"
description (text, nullable),          // USP-tekst voor de winkelpagina
latitude, longitude (nullable),        // voor Google Maps embed
google_maps_url (nullable),
meta_title, meta_description,
is_active, sort_order, timestamps
```

**opening_hours** *(nieuw, per winkel)*
```
id, store_id (FK stores),
day_of_week (tinyint 0-6 of enum ma..zo),
opens_at (time, nullable), closes_at (time, nullable),
is_closed (boolean),                   // bijv. zondag
timestamps
```

**brands**
```
id, name, slug (uniek), logo_path (of via medialibrary),
description (longtext), website_url (nullable),
meta_title, meta_description, is_active, sort_order, timestamps
```

**categories**
```
id, parent_id (nullable, FK categories), name, slug (uniek),
icon (bijv. FontAwesome-class, aansluitend op ontwerp),
description (text, nullable), meta_title, meta_description,
is_active, sort_order, timestamps
```

**products**
```
id, brand_id (FK brands), name, slug (uniek),
short_description (text), description (longtext, nullable),
price (decimal, nullable),             // indicatief, geen webshopprijs
price_label (string, nullable),        // bijv. "vanaf"
is_featured (boolean),                 // toont op categorie-/homepagina
meta_title, meta_description,
is_active, sort_order, timestamps
```

**category_product** (pivot, veel-op-veel)
```
category_id (FK), product_id (FK)
```

**faqs** (polymorf, optioneel)
```
id, faqable_id, faqable_type,   // koppelt aan Product, Category of Page
question (string), answer (text),
sort_order, is_active, timestamps
```

**pages**
```
id, title, slug (uniek), body (longtext / rich text),
template (nullable), meta_title, meta_description,
is_published, published_at, timestamps
```

**menu_items**
```
id, location (enum: top, footer), parent_id (nullable, self),
label, url (nullable), linkable_type (nullable), linkable_id (nullable),
                          // polymorfe link naar Page/Category/Product/Brand/Store
target (_self|_blank), sort_order, is_active, timestamps
```

**hero_slides** *(nieuw)*
```
id, kicker (string, nullable), title, subtitle (text, nullable),
button_label (nullable), button_url (nullable),
image_path (of via medialibrary), sort_order, is_active, timestamps
```

**contact_submissions**
```
id, store_id (nullable, FK stores), product_id (nullable, FK),
first_name, phone (nullable), subject (nullable), message (text),
meta (json: ip, user_agent, herkomst-URL), timestamps
```

**schema_settings**
```
id, key (uniek), value (json), is_active, timestamps
// bijv. organisatie-schema, per-winkel LocalBusiness-gegevens, per-type toggles
```

Media (product-galerij, winkelfoto's, hero-slides) verloopt via **Spatie MediaLibrary**, met conversies (thumb, medium) die aansluiten op de product- en winkelkaarten uit het prototype.

---

## 5. Eloquent-modellen (kern)

```php
// Store.php — nieuw t.o.v. eerdere projecten
class Store extends Model implements HasMedia {
    use HasSlug, InteractsWithMedia;
    protected $fillable = ['name','slug','address_line','postal_code','city',
        'phone','email','shopping_center','description','latitude','longitude',
        'google_maps_url','meta_title','meta_description','is_active','sort_order'];
    public function openingHours() { return $this->hasMany(OpeningHour::class); }
    public function contactSubmissions() { return $this->hasMany(ContactSubmission::class); }
    public function registerMediaCollections(): void {
        $this->addMediaCollection('photo')->singleFile();
    }
}

// OpeningHour.php
class OpeningHour extends Model {
    public function store() { return $this->belongsTo(Store::class); }
}

// Brand.php
class Brand extends Model {
    use HasSlug;
    protected $fillable = ['name','slug','description','website_url',
        'meta_title','meta_description','is_active','sort_order'];
    public function products() { return $this->hasMany(Product::class); }
}

// Category.php — self-referencing boom
class Category extends Model {
    use HasSlug;
    public function parent()   { return $this->belongsTo(Category::class,'parent_id'); }
    public function children() { return $this->hasMany(Category::class,'parent_id'); }
    public function products() { return $this->belongsToMany(Product::class); }
    public function scopeTopLevel($q) { return $q->whereNull('parent_id'); }
}

// Product.php
class Product extends Model implements HasMedia {
    use HasSlug, InteractsWithMedia;
    public function brand()      { return $this->belongsTo(Brand::class); }
    public function categories() { return $this->belongsToMany(Category::class); }
    public function faqs()       { return $this->morphMany(Faq::class,'faqable'); }
    public function registerMediaCollections(): void {
        $this->addMediaCollection('gallery');
    }
}

// Faq.php — polymorf
class Faq extends Model {
    public function faqable() { return $this->morphTo(); }
}
```

Dezelfde patronen gelden voor `Page`, `MenuItem`, `HeroSlide` en `SchemaSetting`.

---

## 6. Routes en controllers (frontend)

Publieke routes (SEO-vriendelijke slugs, aansluitend op de bestaande bestandsnamen `heerhugowaard.html` / `castricum.html`):

```php
Route::get('/',                        HomeController::class);
Route::get('/tassen',                  [CategoryController::class,'show'])->name('cat.tassen');
Route::get('/sieraden',                [CategoryController::class,'show'])->name('cat.sieraden');
Route::get('/horloges',                [CategoryController::class,'show'])->name('cat.horloges');
Route::get('/riemen-sjaals',           [CategoryController::class,'show'])->name('cat.riemen-sjaals');
Route::get('/categorie/{category:slug}',[CategoryController::class,'show']); // generiek, voor nieuwe categorieën
Route::get('/merken',                  [BrandController::class,'index']);
Route::get('/merken/{brand:slug}',     [BrandController::class,'show']);
Route::get('/product/{product:slug}',  [ProductController::class,'show']);
Route::get('/heerhugowaard',           [StoreController::class,'show'])->name('store.heerhugowaard');
Route::get('/castricum',               [StoreController::class,'show'])->name('store.castricum');
Route::get('/winkel/{store:slug}',     [StoreController::class,'show']); // generiek, voor nieuwe vestigingen
Route::get('/contact',                 [ContactController::class,'index']);
Route::post('/contact',                [ContactController::class,'store']);
Route::get('/{page:slug}',             [PageController::class,'show']); // CMS-pagina's, als laatste
```

Kernverantwoordelijkheden:

- **HomeController** — bouwt de hero-slides, USP-blokken, categorie-tegels, uitgelichte winkels en (optioneel) een merkenstrip op uit de admin-content.
- **CategoryController@show** — toont uitgelichte producten binnen de categorie (vgl. `tassen.html`), inclusief het vaste "waarom Nice2Have"-blok en de merken-uitleg per categorie.
- **BrandController@show/index** — merkoverzicht en -pagina met beschrijving en gekoppelde producten.
- **ProductController@show** — optionele productdetailpagina (galerij, beschrijving, gerelateerde producten). In fase 1 kan dit ook wegvallen als de kaarten enkel doorlinken naar de winkel-CTA — zie §11.
- **StoreController@show** — winkelpagina met adres, openingstijden (via `OpeningHour`), kaart/route, foto en kruisverwijzing naar de andere vestiging (vgl. `heerhugowaard.html`/`castricum.html`).
- **ContactController@index/store** — toont het formulier + directe contactgegevens per winkel, valideert (Form Request), slaat optioneel op als `ContactSubmission`, verstuurt Mailable naar de juiste vestiging of algemeen beheer.
- **PageController@show** — rendert CMS-pagina; catch-all route staat bewust onderaan.

---

## 7. CMS & menu-beheer (admin)

Via het admin-panel (Filament) worden beheerd:

- **Winkels** — adres, telefoon, openingstijden (repeater per dag), foto, coördinaten/kaart-URL, beschrijving/USP's, SEO.
- **Pagina's** — titel, slug, rich-text body, SEO-velden, publiceren/concept.
- **Merken** — logo (media), beschrijving, SEO, actief/volgorde.
- **Categorieën** — boomstructuur (top/sub) met drag-and-drop volgorde, icoon, SEO.
- **Producten** — merk kiezen, categorieën koppelen, galerij uploaden, richtprijs (+ label "vanaf"), uitgelicht aan/uit, optionele FAQ's, SEO.
- **Homepage-hero** — slides (afbeelding, kicker, titel, subtekst, knoptekst/-link), volgorde, actief/inactief.
- **Menu's** — twee locaties (top, footer), items nestbaar en sorteerbaar, link naar pagina/categorie/merk/product/winkel of vrije URL.
- **Schema-instellingen** — organisatiegegevens, per-winkel LocalBusiness-data, per-schematype in-/uitschakelen.
- **Inzendingen** — overzicht contactformulier-inzendingen, met winkel-/onderwerpfilter.

Menu's en de winkel-/categorielijst in de footer worden in de frontend als Blade-component gerenderd, zodat top- en footermenu en de winkelsectie volledig databasegestuurd zijn (nu nog hardgecodeerd in het HTML-prototype).

---

## 8. SEO & automatische schema-generatie

Centrale `SchemaService` bouwt JSON-LD op basis van het gerenderde model en de `SchemaSetting`-config. Deze wordt als `<script type="application/ld+json">` in de `<head>` geplaatst.

**Meerdere LocalBusiness-locaties (kern voor Nice2Have):** omdat het bedrijf twee winkels heeft, genereert de service per winkel een `LocalBusiness`/`JewelryStore`-blok (naam, adres, telefoon, openingstijden, geo-coördinaten), gekoppeld aan een overkoepelende `Organization`. Dit is belangrijk voor lokale vindbaarheid ("juwelier Heerhugowaard", "juwelier Castricum") en voor Google Maps/Bedrijfsprofiel-consistentie.

```php
class SchemaService {
    public function localBusiness(Store $store): array {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'JewelryStore',
            'name'     => 'Nice2Have ' . $store->name,
            'address'  => [
                '@type' => 'PostalAddress',
                'streetAddress'   => $store->address_line,
                'postalCode'      => $store->postal_code,
                'addressLocality' => $store->city,
                'addressCountry'  => 'NL',
            ],
            'telephone'      => $store->phone,
            'openingHoursSpecification' => $store->openingHours->map(fn($h) => [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => $h->day_of_week,
                'opens'     => $h->is_closed ? null : $h->opens_at,
                'closes'    => $h->is_closed ? null : $h->closes_at,
            ])->filter(fn($h) => !is_null($h['opens']))->values()->all(),
            'geo' => $store->latitude ? [
                '@type' => 'GeoCoordinates',
                'latitude' => $store->latitude, 'longitude' => $store->longitude,
            ] : null,
        ];
    }
    // + organization(), breadcrumb(), product() (optioneel), faqPage() (optioneel) ...
}
```

**Configureerbaar schemabeheer:** per schematype (Organization, LocalBusiness × winkels, BreadcrumbList, optioneel Product/FAQPage) is via `schema_settings` in te stellen of het actief is en met welke gegevens. Zo blijft schema centraal beheerbaar zonder codewijziging.

Aanvullend: per model instelbare `meta_title`/`meta_description`, automatische canonicals, breadcrumb-schema uit de categorie-/winkelnavigatie, en een automatisch gegenereerde sitemap (Spatie Sitemap).

---

## 9. Homepage & designsysteem uit het prototype

Het meegeleverde HTML-prototype legt het ontwerpsysteem vast en wordt omgezet naar herbruikbare Blade-componenten:

- **Cinematische hero-slider** (`.hero-cine`/`.cine-slide`) — nu hardgecodeerd, wordt gevoed door het `HeroSlide`-model (afbeelding, kicker, titel, subtekst, knop) met Ken Burns-animatie en voortgangsbalk zoals in het prototype.
- **USP-kaarten** (`Twee winkels`, `Toonaangevende merken`, `Hip & betaalbaar`) — vaste content-blokken, beheerbaar als eenvoudige repeater in de admin (icoon + titel + tekst) zodat de tekst en iconen aanpasbaar blijven zonder code.
- **Categorie-tegels** (`.cat-card`) — gegenereerd uit de actieve topcategorieën, met foto en overlay-titel.
- **Winkelkaarten** (`.store-card`) — gegenereerd uit het `Store`-model: foto, adres, telefoon, samengevatte openingstijden, link naar de winkelpagina.
- **Productkaarten** (`.product-card`) — merk, naam, richtprijs; standaard zonder besteloptie.
- **Kleur-tokens** (CSS-variabelen `--rose`, `--rose-dark`, `--dark`, `--cream`) blijven vaste huisstijl, geen per-project theming nodig (in tegenstelling tot eerdere multi-project bouwplannen).
- **Kaart-component** — vervangt de `map-placeholder` uit `castricum.html`/`heerhugowaard.html` door een echte Google Maps embed op basis van `latitude`/`longitude` of `google_maps_url` per winkel.

---

## 10. Contactformulier & verzending

- Formuliervelden conform prototype (`contact.html`): naam, telefoon, onderwerp, bericht.
- **Aanbevolen toevoeging:** een verplicht privacy-akkoord-veld, dat in het huidige prototype nog ontbreekt maar wettelijk gewenst is bij het verwerken van persoonsgegevens (AVG).
- Optioneel: een winkelkeuze (Heerhugowaard/Castricum/"maakt niet uit") zodat een vraag naar de juiste vestiging gerouteerd kan worden.
- Validatie via een `ContactRequest` (Form Request).
- Verzending via een `Mailable` naar het algemene beheeradres (`info@nice-2-have.nl`) en/of het winkel-specifieke adres, optioneel met een automatische bevestigingsmail aan de aanvrager.
- Bescherming: honeypot-veld + `throttle`-rate limiting; optionele opslag als `ContactSubmission` voor overzicht in de admin.
- Directe contactgegevens (telefoonnummers per winkel, algemeen e-mailadres, Instagram/Facebook-links) blijven statisch beheerbaar via `SchemaSetting`/site-instellingen, zodat ze centraal wijzigbaar zijn.

---

## 11. Fasering

**Fase 1 — Basisimplementatie (deze opdracht)**
Projectopzet, datamodel + migraties, admin (Filament) voor winkels/openingstijden/merken/categorieën/producten/pagina's/menu's/hero-slides, frontend (home, categorie-, merk-, winkel- en CMS-pagina's), galerij, contactformulier met verzending, Google Maps-integratie per winkel, meerdere LocalBusiness-schema's, sitemap/SEO-basis.

**Fase 2 — Voorbereid, buiten scope nu**
Productdetailpagina's met FAQ + FAQ-schema, merkoverzichtspagina volledig uitgewerkt (nu alleen menu-item), online cadeaubon-verkoop, nieuwsbrief/e-mailmarketing-integratie, uitbreiding naar eventuele derde winkellocatie, meertaligheid.

---

## 12. Aandachtspunten

- Nice2Have is nadrukkelijk **geen webshop**: geen "toevoegen aan winkelwagen", geen voorraadweergave, geen online afrekenen. Elke uitbreiding in die richting is een bewuste scope-wijziging, geen "vanzelfsprekende volgende stap".
- Prijzen op productkaarten zijn indicatief ("vanaf") omdat het assortiment continu wisselt — dit verschilt fundamenteel van een prijs-/voorraadgedreven catalogus zoals bij eerdere Worldwebdesign-projecten.
- Winkel-specifieke content (openingstijden, "volledig assortiment" vs. regulier, parkeren, betaalmethoden) mag per winkel verschillen; bouw dit dus als velden op `Store`/`OpeningHour`, niet als vaste tekst in de Blade-template.
- Meerdere `LocalBusiness`-schema's op één site vragen om zorgvuldige opbouw (elk gekoppeld aan de juiste `Organization` via `@id`), zodat Google de twee vestigingen niet als duplicaten interpreteert.
- Mega-menu/footermenu databasegestuurd maken (niet de huidige hardgecodeerde `<ul>` overnemen) zodat nieuwe categorieën of een derde winkel automatisch doorwerken in menu, footer en schema/breadcrumbs.
- Media-conversies vooraf definiëren (thumb/medium/hoofd) passend bij de kaart- en hero-afmetingen uit het prototype.
- Catch-all CMS-route als laatste registreren om conflicten met de vaste winkel-/categorie-routes te voorkomen.
- Voeg het privacy-akkoord toe aan het contactformulier vóór livegang (zie §10) — dit ontbreekt nog in het huidige prototype.
