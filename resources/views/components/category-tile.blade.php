@props(['category', 'index' => 1])

<a href="{{ route('category.show', $category->slug) }}" class="cat-card {{ $category->photoUrl() ? '' : 'cat-card--'.((($index - 1) % 4) + 1) }}">
    @if ($category->photoUrl())
        <img src="{{ $category->photoUrl() }}" alt="{{ $category->name }}" class="cat-card__image">
    @endif
    <div class="cat-card__overlay"></div>
    <span class="cat-card__title">{{ $category->name }}</span>
</a>
