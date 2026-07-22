<x-layout :meta-title="$page->meta_title ?: $page->title.' — Nice2Have'" :meta-description="$page->meta_description">
    @push('schema')
        <x-schema :data="app(\App\Services\SchemaService::class)->breadcrumb([
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $page->title, 'url' => route('page.show', $page->slug)],
        ])" />
    @endpush

    <section class="py-5">
        <div class="container" style="max-width: 720px;">
            <h1 class="font-display mb-4">{{ $page->title }}</h1>
            <div>{!! $page->body !!}</div>
        </div>
    </section>
</x-layout>
