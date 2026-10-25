@extends('layouts.app')

@section('title', __('app.catalog'))

@section('content')

@if(!$currentSearch && !$currentGenre && !$currentType)
    <!-- 1. Top Featured Carousel / Banner (Trending Blockbusters) -->
    @php
        $featuredShows = $tvSeries->concat($movies)->concat($anime)->take(4);
    @endphp

    @if($featuredShows->count() > 0)
        <section class="hero-featured-grid">
            @foreach($featuredShows as $feat)
                <div class="featured-card">
                    <a href="{{ route('catalog.show', $feat->slug) }}" class="card-link-overlay" aria-label="{{ $feat->localized_title }}"></a>
                    <img src="{{ $feat->poster_image }}" alt="{{ $feat->localized_title }}" loading="lazy">
                    <div class="featured-overlay">
                        <h3>
                            <a href="{{ route('catalog.show', $feat->slug) }}" style="color: #ffffff;">
                                {{ $feat->localized_title }} ({{ $feat->release_year }})
                            </a>
                        </h3>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="like-btn">
                                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'مميز' : 'Featured' }}</span>
                            </span>
                            <span style="font-size: 0.75rem; background: #2563eb; color: #ffffff; padding: 0.15rem 0.5rem; border-radius: 4px; font-weight: 800; display: inline-flex; align-items: center; gap: 0.25rem;">
                                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #fbbf24;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>{{ $feat->average_rating > 0 ? $feat->average_rating : '9.5' }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>
    @endif

    <!-- 2. SECTION 1: American & Western TV Series (IMDb) -->
    <section class="section-block">
        <div class="section-title-bar">
            <div class="section-title-left">
                <div class="section-title-heading">
                    <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--primary);"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'المسلسلات التلفزيونية العالمية (IMDb)' : 'American & Global TV Series (IMDb)' }}</span>
                </div>
                <span class="section-title-badge">{{ app()->getLocale() === 'ar' ? 'الأعلى تقييماً' : 'Top Rated' }}</span>
            </div>

            <div class="section-title-right">
                <a href="{{ route('catalog', ['type' => 'TV']) }}" class="section-view-all">
                    <span>{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }}</span>
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
                <button type="button" class="scroll-arrow-btn" onclick="scrollSection('tv-series-track', -360)" title="Previous">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="scroll-arrow-btn" onclick="scrollSection('tv-series-track', 360)" title="Next">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>

        <div class="horizontal-scroll-track" id="tv-series-track">
            @foreach($tvSeries as $item)
                <div class="scroll-card">
                    <div class="scroll-card-thumb">
                        <a href="{{ route('catalog.show', $item->slug) }}" class="card-link-overlay" aria-label="{{ $item->localized_title }}"></a>
                        <img src="{{ $item->poster_image }}" alt="{{ $item->localized_title }}" loading="lazy">
                        
                        <span class="mycima-badge-ep">
                            {{ app()->getLocale() === 'ar' ? 'مواسم ' . $item->total_episodes . ' حلقة' : $item->total_episodes . ' Eps' }}
                        </span>

                        <span class="mycima-badge-score">
                            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #fbbf24; width: 12px; height: 12px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>{{ $item->average_rating > 0 ? $item->average_rating : '9.2' }}</span>
                        </span>
                    </div>

                    <div class="scroll-card-info">
                        <h4 class="scroll-card-title">
                            <a href="{{ route('catalog.show', $item->slug) }}">
                                {{ $item->localized_title }}
                            </a>
                        </h4>

                        <div class="scroll-card-sub">
                            <span>{{ $item->release_year }} • TV Series</span>
                            <span style="color: {{ $item->status === 'Airing' ? '#10b981' : 'var(--text-muted)' }}; font-weight: 700;">
                                {{ $item->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 3. SECTION 2: Blockbuster Movies -->
    <section class="section-block">
        <div class="section-title-bar">
            <div class="section-title-left">
                <div class="section-title-heading">
                    <svg class="svg-icon" viewBox="0 0 24 24" style="color: #f59e0b;"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect><line x1="7" y1="2" x2="7" y2="22"></line><line x1="17" y1="2" x2="17" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><line x1="2" y1="7" x2="7" y2="7"></line><line x1="2" y1="17" x2="7" y2="17"></line><line x1="17" y1="17" x2="22" y2="17"></line><line x1="17" y1="7" x2="22" y2="7"></line></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'الأفلام السينمائية العالمية (Blockbusters)' : 'Blockbuster & Featured Movies' }}</span>
                </div>
                <span class="section-title-badge" style="background: rgba(245, 158, 11, 0.15); color: #d97706; border-color: rgba(245, 158, 11, 0.3);">
                    {{ app()->getLocale() === 'ar' ? 'سينما 4K' : '4K UHD' }}
                </span>
            </div>

            <div class="section-title-right">
                <a href="{{ route('catalog', ['type' => 'Movie']) }}" class="section-view-all">
                    <span>{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }}</span>
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
                <button type="button" class="scroll-arrow-btn" onclick="scrollSection('movies-track', -360)" title="Previous">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="scroll-arrow-btn" onclick="scrollSection('movies-track', 360)" title="Next">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>

        <div class="horizontal-scroll-track" id="movies-track">
            @foreach($movies as $item)
                <div class="scroll-card">
                    <div class="scroll-card-thumb">
                        <a href="{{ route('catalog.show', $item->slug) }}" class="card-link-overlay" aria-label="{{ $item->localized_title }}"></a>
                        <img src="{{ $item->poster_image }}" alt="{{ $item->localized_title }}" loading="lazy">
                        
                        <span class="mycima-badge-ep" style="background: #b45309;">
                            {{ app()->getLocale() === 'ar' ? 'فيلم كامل' : 'Full Movie' }}
                        </span>

                        <span class="mycima-badge-score">
                            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #fbbf24; width: 12px; height: 12px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>{{ $item->average_rating > 0 ? $item->average_rating : '9.0' }}</span>
                        </span>
                    </div>

                    <div class="scroll-card-info">
                        <h4 class="scroll-card-title">
                            <a href="{{ route('catalog.show', $item->slug) }}">
                                {{ $item->localized_title }}
                            </a>
                        </h4>

                        <div class="scroll-card-sub">
                            <span>{{ $item->release_year }} • Movie</span>
                            <span style="color: #3b82f6; font-weight: 700;">
                                4K Ultra HD
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- 4. SECTION 3: Japanese Anime (Crunchyroll) -->
    <section class="section-block">
        <div class="section-title-bar">
            <div class="section-title-left">
                <div class="section-title-heading">
                    <svg class="svg-icon" viewBox="0 0 24 24" style="color: #10b981;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'الأنمي الياباني والرسوم المتحركة (Crunchyroll)' : 'Japanese Anime Series (Crunchyroll)' }}</span>
                </div>
                <span class="section-title-badge" style="background: rgba(16, 185, 129, 0.15); color: #059669; border-color: rgba(16, 185, 129, 0.3);">
                    {{ app()->getLocale() === 'ar' ? 'مترجم وحصري' : 'Sub & Dub' }}
                </span>
            </div>

            <div class="section-title-right">
                <a href="{{ route('catalog', ['type' => 'anime']) }}" class="section-view-all">
                    <span>{{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }}</span>
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
                <button type="button" class="scroll-arrow-btn" onclick="scrollSection('anime-track', -360)" title="Previous">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="scroll-arrow-btn" onclick="scrollSection('anime-track', 360)" title="Next">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>

        <div class="horizontal-scroll-track" id="anime-track">
            @foreach($anime as $item)
                <div class="scroll-card">
                    <div class="scroll-card-thumb">
                        <a href="{{ route('catalog.show', $item->slug) }}" class="card-link-overlay" aria-label="{{ $item->localized_title }}"></a>
                        <img src="{{ $item->poster_image }}" alt="{{ $item->localized_title }}" loading="lazy">
                        
                        <span class="mycima-badge-ep" style="background: #047857;">
                            {{ app()->getLocale() === 'ar' ? 'حلقة ' . min(24, $item->total_episodes) : 'Ep ' . min(24, $item->total_episodes) }}
                        </span>

                        <span class="mycima-badge-score">
                            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #fbbf24; width: 12px; height: 12px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>{{ $item->average_rating > 0 ? $item->average_rating : '9.3' }}</span>
                        </span>
                    </div>

                    <div class="scroll-card-info">
                        <h4 class="scroll-card-title">
                            <a href="{{ route('catalog.show', $item->slug) }}">
                                {{ $item->localized_title }}
                            </a>
                        </h4>

                        <div class="scroll-card-sub">
                            <span>{{ $item->release_year }} • Anime</span>
                            <span style="color: {{ $item->status === 'Airing' ? '#10b981' : 'var(--text-muted)' }}; font-weight: 700;">
                                {{ $item->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@else
    <!-- Filtered / Search Results View -->
    <div class="section-header-bar" style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--primary);"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text-primary);">
                    @if($currentType === 'TV')
                        {{ app()->getLocale() === 'ar' ? 'المسلسلات التلفزيونية الأمريكية' : 'American TV Series' }}
                    @elseif($currentType === 'Movie')
                        {{ app()->getLocale() === 'ar' ? 'الأفلام السينمائية العالمية' : 'Featured Movies' }}
                    @elseif($currentType === 'anime')
                        {{ app()->getLocale() === 'ar' ? 'الأنمي الياباني' : 'Japanese Anime' }}
                    @elseif($currentGenre)
                        {{ app()->getLocale() === 'ar' ? 'تصنيف: ' . $currentGenre : 'Genre: ' . $currentGenre }}
                    @elseif($currentSearch)
                        {{ app()->getLocale() === 'ar' ? 'نتائج البحث عن: ' . $currentSearch : 'Search results for: ' . $currentSearch }}
                    @endif
                </h3>
                <span style="font-size: 0.8rem; color: var(--text-muted);">
                    {{ $seriesList->total() }} {{ app()->getLocale() === 'ar' ? 'عمل مطابق' : 'titles found' }}
                </span>
            </div>
        </div>

        <div>
            <a href="{{ route('catalog') }}" class="btn btn-secondary btn-sm">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                <span>{{ __('app.reset') }}</span>
            </a>
        </div>
    </div>

    @if($seriesList->count() > 0)
        <div class="mycima-grid">
            @foreach($seriesList as $series)
                <div class="mycima-card">
                    <div class="mycima-card-thumb">
                        <a href="{{ route('catalog.show', $series->slug) }}" class="card-link-overlay" aria-label="{{ $series->localized_title }}"></a>
                        <img src="{{ $series->poster_image }}" alt="{{ $series->localized_title }}" loading="lazy">
                        
                        <span class="mycima-badge-ep">
                            {{ $series->type === 'Movie' ? (app()->getLocale() === 'ar' ? 'فيلم' : 'Movie') : (app()->getLocale() === 'ar' ? 'حلقة ' . min(24, $series->total_episodes) : 'Ep ' . min(24, $series->total_episodes)) }}
                        </span>

                        <span class="mycima-badge-score">
                            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #fbbf24; width: 12px; height: 12px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>{{ $series->average_rating > 0 ? $series->average_rating : '9.0' }}</span>
                        </span>
                    </div>

                    <div class="mycima-card-info">
                        <h3 class="mycima-card-title">
                            <a href="{{ route('catalog.show', $series->slug) }}">
                                {{ $series->localized_title }} ({{ $series->release_year }})
                            </a>
                        </h3>

                        <div class="mycima-card-sub">
                            <span>{{ $series->type }} • {{ $series->total_episodes }} {{ __('app.episodes') }}</span>
                            <span style="color: {{ $series->status === 'Airing' ? '#10b981' : 'var(--text-muted)' }}; font-weight: 700;">
                                {{ $series->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $seriesList->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 1.5rem; background: var(--bg-surface); border: 1px dashed var(--border-subtle); border-radius: var(--radius-md);">
            <p style="color: var(--text-muted); font-size: 1rem; margin-bottom: 1rem;">
                {{ app()->getLocale() === 'ar' ? 'لم يتم العثور على أي أعمال مطابقة للبحث أو الفلتر.' : 'No titles matched your active search or filter.' }}
            </p>
            <a href="{{ route('catalog') }}" class="btn btn-secondary">
                {{ __('app.reset') }}
            </a>
        </div>
    @endif
@endif

@push('scripts')
<script>
    function scrollSection(trackId, offset) {
        const track = document.getElementById(trackId);
        if (!track) return;
        const isRtl = document.documentElement.getAttribute('dir') === 'rtl';
        // In modern browsers with dir="rtl", scroll left delta direction is reversed
        const delta = isRtl ? -offset : offset;
        track.scrollBy({ left: delta, behavior: 'smooth' });
    }
</script>
@endpush

@endsection
