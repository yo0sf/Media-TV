@extends('layouts.app')

@section('title', __('app.watchlist'))

@section('content')
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2.2rem; font-weight: 900; margin-bottom: 0.4rem; color: var(--text-primary);">
            {{ __('app.watchlist') }}
        </h1>
        <p style="color: var(--text-muted); font-size: 0.95rem;">
            {{ app()->getLocale() === 'ar' ? 'سجل متابعتك الشخصي لحلقات المسلسلات والأنمي وحالات الاكتمال.' : 'Track your personal viewing catalog and episode progress across all lifecycle states.' }}
        </p>
    </div>

    <!-- Watchlist Status Filter Tabs -->
    <div style="display: flex; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 2rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 1.25rem;">
        <a href="{{ route('watchlist.index') }}" class="btn {{ empty($currentStatus) ? 'btn-primary' : 'btn-secondary' }} btn-sm">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <span>{{ app()->getLocale() === 'ar' ? 'كافة العروض' : 'All Titles' }}</span>
        </a>
        @foreach(['Watching', 'Completed', 'Plan to Watch', 'On Hold', 'Dropped'] as $st)
            <a href="{{ route('watchlist.index', ['status' => $st]) }}" class="btn {{ $currentStatus === $st ? 'btn-primary' : 'btn-secondary' }} btn-sm">
                <span>{{ __('app.status_' . Str::slug($st, '_')) }}</span>
            </a>
        @endforeach
    </div>

    @if($watchlists->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 1.15rem;">
            @foreach($watchlists as $item)
                <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.25rem; display: grid; grid-template-columns: 85px 1fr auto; gap: 1.5rem; align-items: center; box-shadow: var(--card-shadow);">
                    
                    <!-- Poster Thumbnail -->
                    <div style="aspect-ratio: 2 / 3; border-radius: 8px; overflow: hidden; background: var(--bg-elevated); box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                        @if($item->series->poster_image)
                            <img src="{{ $item->series->poster_image }}" alt="{{ $item->series->localized_title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    </div>

                    <!-- Series Info & Progress Bar -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.45rem; flex-wrap: wrap;">
                            <h2 style="font-size: 1.2rem; font-weight: 800; color: var(--text-primary);">
                                <a href="{{ route('catalog.show', $item->series->slug) }}">
                                    {{ $item->series->localized_title }}
                                </a>
                            </h2>
                            <span class="genre-pill">
                                {{ __('app.status_' . Str::slug($item->status, '_')) }}
                            </span>
                        </div>

                        <!-- Progress Metrics -->
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.88rem; color: var(--text-secondary); font-weight: 600;">
                            <span>
                                {{ __('app.progress') }}: <strong style="color: var(--text-primary); font-size: 1rem;">{{ $item->progress_episodes }}</strong> / {{ $item->series->total_episodes }} {{ __('app.episodes') }}
                            </span>
                            <span style="font-weight: 800; color: var(--primary);">{{ $item->progress_percentage }}%</span>
                        </div>

                        <!-- Progress Bar Line -->
                        <div style="width: 100%; height: 8px; background: var(--bg-elevated); border: 1px solid var(--border-subtle); border-radius: 4px; overflow: hidden;">
                            <div style="width: {{ $item->progress_percentage }}%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); transition: width 0.3s ease;"></div>
                        </div>
                    </div>

                    <!-- Action Controls -->
                    <div style="display: flex; flex-direction: column; gap: 0.6rem; min-width: 160px;">
                        <form action="{{ route('watchlist.increment', $item->series) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">
                                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                <span>{{ __('app.increment_ep') }}</span>
                            </button>
                        </form>

                        <div style="display: flex; gap: 0.5rem;">
                            <form action="{{ route('watchlist.decrement', $item->series) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm" style="width: 100%;">
                                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>-1</span>
                                </button>
                            </form>

                            <form action="{{ route('watchlist.destroy', $item->series) }}" method="POST" onsubmit="return confirm('Remove from watchlist?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Remove">
                                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $watchlists->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4.5rem 1.5rem; background: var(--bg-surface); border: 1px dashed var(--border-subtle); border-radius: var(--radius-lg); box-shadow: var(--card-shadow);">
            <p style="font-size: 1.15rem; color: var(--text-muted); margin-bottom: 1.25rem; font-weight: 600;">
                {{ app()->getLocale() === 'ar' ? 'لا توجد أعمال في قائمة المتابعة لهذه الحالة حالياً.' : 'Your watchlist is empty for this selected filter.' }}
            </p>
            <a href="{{ route('catalog') }}" class="btn btn-primary">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>
                <span>{{ __('app.catalog') }}</span>
            </a>
        </div>
    @endif
@endsection
