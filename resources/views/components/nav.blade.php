<nav class="navbar navbar-expand-lg navbar-n2h sticky-top py-3">
    <div class="container">
        <a class="navbar-brand fs-4" href="{{ url('/') }}">
            <span class="brand-logo__nice">NICE</span><span class="brand-logo__2">2</span><span class="brand-logo__have">HAVE</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto gap-lg-4">
                @foreach ($items as $item)
                    <li class="nav-item {{ $item->children->isNotEmpty() ? 'dropdown' : '' }}">
                        @if ($item->children->isNotEmpty())
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ $item->label }}
                            </a>
                            <ul class="dropdown-menu">
                                @foreach ($item->children as $child)
                                    <li>
                                        <a class="dropdown-item" href="{{ $child->resolvedUrl() }}" target="{{ $child->target }}">
                                            {{ $child->label }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a class="nav-link {{ $item->isActive() ? 'active' : '' }}" href="{{ $item->resolvedUrl() }}" target="{{ $item->target }}">
                                {{ $item->label }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
