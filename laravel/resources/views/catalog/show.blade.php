@extends('layouts.app')

@section('title', $series->localized_title)

@section('content')
    <div style="display: grid; grid-template-columns: 310px 1fr; gap: 2rem; align-items: start;">
        
        <!-- Left Sidebar: Poster & Watchlist Quick Box -->
        <div>
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--card-shadow);">
                <div style="aspect-ratio: 2 / 3; overflow: hidden; background: var(--bg-elevated); position: relative;">
                    @if($series->poster_image)
                        <img src="{{ $series->poster_image }}" alt="{{ $series->localized_title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                    <div style="position: absolute; top: 0.75rem; inset-inline-end: 0.75rem; background: rgba(0,0,0,0.85); color: #fbbf24; padding: 0.3rem 0.6rem; border-radius: 6px; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; gap: 0.3rem; border: 1px solid rgba(251, 191, 36, 0.3);">
                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #fbbf24;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>{{ $series->average_rating > 0 ? $series->average_rating : '9.0' }}</span>
                    </div>
                </div>

                <div style="padding: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 0.75rem;">
                        <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700;">{{ __('app.score') }}</span>
                        <span style="font-weight: 800; color: #f59e0b; font-size: 1.1rem;">
                            {{ $series->average_rating > 0 ? $series->average_rating . ' / 10' : '9.0 / 10' }}
                        </span>
                    </div>

                    <!-- Watchlist Action Box -->
                    @auth
                        <div style="background: var(--bg-elevated); padding: 1.1rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                            <form action="{{ route('watchlist.store', $series) }}" method="POST">
                                @csrf
                                <div class="form-group" style="margin-bottom: 0.85rem;">
                                    <label class="form-label" style="font-size: 0.82rem; color: var(--text-primary);">{{ __('app.status') }}</label>
                                    <select name="status" class="form-select" style="padding: 0.5rem 0.75rem; font-size: 0.88rem;">
                                        @foreach(['Plan to Watch', 'Watching', 'Completed', 'On Hold', 'Dropped'] as $st)
                                            <option value="{{ $st }}" {{ ($userWatchlist && $userWatchlist->status === $st) ? 'selected' : '' }}>
                                                {{ __('app.status_' . Str::slug($st, '_')) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group" style="margin-bottom: 1rem;">
                                    <label class="form-label" style="font-size: 0.82rem; color: var(--text-primary);">
                                        {{ __('app.progress') }} ({{ __('app.episodes') }})
                                    </label>
                                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                                        <input 
                                            type="number" 
                                            name="progress_episodes" 
                                            min="0" 
                                            max="{{ $series->total_episodes }}" 
                                            value="{{ $userWatchlist ? $userWatchlist->progress_episodes : 0 }}"
                                            class="form-input" 
                                            style="padding: 0.5rem 0.75rem; font-size: 0.88rem;"
                                        >
                                        <span style="color: var(--text-muted); font-size: 0.85rem; font-weight: 700; white-space: nowrap;">/ {{ $series->total_episodes }}</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">
                                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                                    <span>{{ $userWatchlist ? __('app.update_watchlist') : __('app.add_to_watchlist') }}</span>
                                </button>
                            </form>

                            @if($userWatchlist)
                                <div style="display: flex; gap: 0.5rem; margin-top: 0.75rem;">
                                    <form action="{{ route('watchlist.increment', $series) }}" method="POST" style="flex: 1;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary btn-sm" style="width: 100%;">
                                            {{ __('app.increment_ep') }}
                                        </button>
                                    </form>

                                    <form action="{{ route('watchlist.destroy', $series) }}" method="POST" onsubmit="return confirm('Remove from watchlist?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="{{ __('app.remove_from_watchlist') }}">
                                            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Guest Prompt -->
                        <div style="background: var(--primary-light); border: 1px dashed var(--primary); padding: 1.15rem; border-radius: var(--radius-md); text-align: center;">
                            <p style="font-size: 0.88rem; color: var(--text-secondary); margin-bottom: 0.85rem; line-height: 1.6;">
                                {{ __('app.must_login_notice') }}
                            </p>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm" style="width: 100%;">
                                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                                <span>{{ __('app.login') }}</span>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Right Content: Info, Episodes & Reviews -->
        <div>
            <!-- Header Titles -->
            <div style="margin-bottom: 1.5rem;">
                <h1 style="font-size: 2.2rem; font-weight: 900; margin-bottom: 0.35rem; color: var(--text-primary); line-height: 1.3;">
                    {{ $series->localized_title }}
                </h1>
                @if(app()->getLocale() === 'ar' && !empty($series->title_en))
                    <h2 style="font-size: 1.1rem; color: var(--text-muted); font-weight: 600;">
                        {{ $series->title_en }}
                    </h2>
                @elseif(app()->getLocale() === 'en' && !empty($series->title_ar))
                    <h2 style="font-size: 1.1rem; color: var(--text-muted); font-weight: 600;">
                        {{ $series->title_ar }}
                    </h2>
                @endif
            </div>

            <!-- Metadata Badges -->
            <div style="display: flex; flex-wrap: wrap; gap: 0.6rem; margin-bottom: 1.75rem;">
                <span class="genre-pill">{{ $series->type }}</span>
                <span class="genre-pill">{{ $series->release_year }}</span>
                <span class="genre-pill">{{ $series->total_episodes }} {{ __('app.episodes') }}</span>
                <span class="genre-pill" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border-color: rgba(16, 185, 129, 0.35);">
                    {{ $series->status }}
                </span>
                @foreach($series->genres as $genre)
                    <span class="genre-pill" style="background: rgba(139, 92, 246, 0.15); color: var(--accent); border-color: rgba(139, 92, 246, 0.35);">
                        {{ $genre->localized_name }}
                    </span>
                @endforeach
            </div>

            <!-- Synopsis Section -->
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.75rem; box-shadow: var(--card-shadow);">
                <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 0.75rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.45rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    <span>{{ __('app.synopsis') }}</span>
                </h3>
                <p style="color: var(--text-secondary); line-height: 1.85; font-size: 0.95rem;">
                    {{ $series->localized_synopsis }}
                </p>
            </div>

            <!-- Episodes Section -->
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem; margin-bottom: 1.75rem; box-shadow: var(--card-shadow);">
                <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 1rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.45rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>
                    <span>{{ __('app.episodes') }} ({{ $series->episodes->count() }})</span>
                </h3>
                
                @if($series->episodes->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 0.85rem;">
                        @foreach($series->episodes as $episode)
                            <div style="background: var(--bg-elevated); padding: 0.85rem 1.1rem; border-radius: var(--radius-sm); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; gap: 0.75rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    @if($episode->thumbnail_url)
                                        <img src="{{ $episode->thumbnail_url }}" alt="" style="width: 50px; height: 32px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-subtle); flex-shrink: 0;">
                                    @endif
                                    <div>
                                        <span style="font-weight: 800; color: var(--primary); font-size: 0.85rem;">#{{ $episode->episode_number }}</span>
                                        <p style="font-size: 0.88rem; color: var(--text-primary); font-weight: 600;">{{ $episode->localized_title }}</p>
                                    </div>
                                </div>
                                @if($episode->air_date)
                                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; white-space: nowrap;">{{ $episode->air_date }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--text-muted); font-size: 0.9rem;">
                        {{ app()->getLocale() === 'ar' ? 'يجري تحديث وإضافة الحلقات لهذا العمل حالياً.' : 'Episode guides are currently being populated.' }}
                    </p>
                @endif
            </div>

            <!-- Community Reviews & Ratings -->
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.5rem; box-shadow: var(--card-shadow);">
                <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 1.25rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.45rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    <span>{{ __('app.reviews') }} ({{ $series->reviews->count() }})</span>
                </h3>

                <!-- Submit Review Form -->
                @auth
                    <form action="{{ route('reviews.store', $series) }}" method="POST" style="background: var(--bg-elevated); border: 1px solid var(--border-subtle); padding: 1.25rem; border-radius: var(--radius-md); margin-bottom: 2rem;">
                        @csrf
                        <h4 style="font-size: 0.98rem; font-weight: 800; margin-bottom: 0.85rem; color: var(--text-primary);">
                            {{ __('app.leave_review') }}
                        </h4>
                        
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                            <div style="width: 150px;">
                                <label class="form-label" style="font-size: 0.82rem;">{{ __('app.your_rating') }}</label>
                                <select name="rating" class="form-select" required>
                                    @for($r = 10; $r >= 1; $r--)
                                        <option value="{{ $r }}" {{ ($userReview && $userReview->rating == $r) ? 'selected' : '' }}>
                                            ★ {{ $r }} / 10
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div style="flex: 1; min-width: 260px;">
                                <label class="form-label" style="font-size: 0.82rem;">{{ __('app.your_review') }}</label>
                                <textarea name="comment" rows="2" class="form-textarea" placeholder="{{ __('app.your_review') }}">{{ $userReview ? $userReview->comment : '' }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">
                            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            <span>{{ __('app.submit_review') }}</span>
                        </button>
                    </form>
                @endauth

                <!-- Reviews Listing -->
                @if($series->reviews->count() > 0)
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @foreach($series->reviews as $review)
                            <div style="background: var(--bg-elevated); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.15rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem;">
                                    <div>
                                        <strong style="color: var(--text-primary); font-size: 0.95rem;">{{ $review->user->name }}</strong>
                                        <span style="color: var(--text-muted); font-size: 0.78rem; margin-inline-start: 0.6rem;">
                                            {{ $review->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <span style="color: #fbbf24; font-weight: 800; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.2rem;">
                                        ★ {{ $review->rating }} / 10
                                    </span>
                                </div>
                                @if($review->comment)
                                    <p style="color: var(--text-secondary); font-size: 0.92rem; line-height: 1.7;">
                                        {{ $review->comment }}
                                    </p>
                                @endif

                                @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->isManager()))
                                    <div style="margin-top: 0.6rem; text-align: end;">
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display: inline;" onsubmit="return confirm('Delete review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; border: none; color: #ef4444; font-size: 0.8rem; cursor: pointer; text-decoration: underline; font-weight: 700;">
                                                {{ __('app.delete') }}
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--text-muted); font-size: 0.92rem;">
                        {{ __('app.no_reviews_yet') }}
                    </p>
                @endif
            </div>
        </div>

    </div>
@endsection
