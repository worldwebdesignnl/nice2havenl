@props(['brands'])

@if ($brands->isNotEmpty())
    <div class="brand-ticker">
        <div class="brand-ticker__track">
            @for ($pass = 0; $pass < 2; $pass++)
                @foreach ($brands as $brand)
                    <span class="brand-ticker__item">{{ $brand->name }}</span>
                @endforeach
            @endfor
        </div>
    </div>
@endif
