@props(['blocks'])

<div class="container">
    <div class="row">
        @foreach ($blocks as $block)
            <div class="col-md-4">
                <div class="usp-card">
                    @if ($block->icon)
                        <div class="usp-card__icon"><i class="{{ $block->icon }}"></i></div>
                    @endif
                    <h3 class="h5 font-display">{{ $block->title }}</h3>
                    <p class="mb-0">{{ $block->text }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
