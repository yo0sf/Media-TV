@if ($paginator->hasPages())
    <nav class="custom-pagination" role="navigation" aria-label="Pagination Navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-btn disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                <svg class="pagination-icon" viewBox="0 0 24 24">
                    @if(app()->getLocale() === 'ar')
                        <polyline points="9 18 15 12 9 6"></polyline>
                    @else
                        <polyline points="15 18 9 12 15 6"></polyline>
                    @endif
                </svg>
                <span>{{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-btn" aria-label="{{ __('pagination.previous') }}">
                <svg class="pagination-icon" viewBox="0 0 24 24">
                    @if(app()->getLocale() === 'ar')
                        <polyline points="9 18 15 12 9 6"></polyline>
                    @else
                        <polyline points="15 18 9 12 15 6"></polyline>
                    @endif
                </svg>
                <span>{{ app()->getLocale() === 'ar' ? 'السابق' : 'Previous' }}</span>
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="pagination-numbers">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-number dots" aria-disabled="true">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-number active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-btn" aria-label="{{ __('pagination.next') }}">
                <span>{{ app()->getLocale() === 'ar' ? 'التالي' : 'Next' }}</span>
                <svg class="pagination-icon" viewBox="0 0 24 24">
                    @if(app()->getLocale() === 'ar')
                        <polyline points="15 18 9 12 15 6"></polyline>
                    @else
                        <polyline points="9 18 15 12 9 6"></polyline>
                    @endif
                </svg>
            </a>
        @else
            <span class="pagination-btn disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                <span>{{ app()->getLocale() === 'ar' ? 'التالي' : 'Next' }}</span>
                <svg class="pagination-icon" viewBox="0 0 24 24">
                    @if(app()->getLocale() === 'ar')
                        <polyline points="15 18 9 12 15 6"></polyline>
                    @else
                        <polyline points="9 18 15 12 9 6"></polyline>
                    @endif
                </svg>
            </span>
        @endif
    </nav>
@endif
