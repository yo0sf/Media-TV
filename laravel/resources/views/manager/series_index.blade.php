@extends('layouts.app')

@section('title', __('app.manager_portal'))

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.25rem;">
                {{ __('app.manager_portal') }}
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">{{ __('app.manage_catalog') }}</p>
        </div>

        <div style="display: flex; gap: 0.6rem; flex-wrap: wrap;">
            <a href="{{ route('manager.genres.index') }}" class="btn btn-secondary btn-sm">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span>{{ __('app.manage_genres') }}</span>
            </a>
            <a href="{{ route('manager.moderation.index') }}" class="btn btn-secondary btn-sm">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <span>{{ __('app.content_moderation') }}</span>
            </a>
            <a href="{{ route('manager.series.create') }}" class="btn btn-primary btn-sm">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>{{ __('app.create_new_series') }}</span>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'العنوان' : 'Title' }}</th>
                    <th>{{ __('app.type') }}</th>
                    <th>{{ __('app.episodes') }}</th>
                    <th>{{ __('app.year') }}</th>
                    <th>{{ __('app.status') }}</th>
                    <th style="text-align: end;">{{ __('app.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($series as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            <strong style="color: var(--text-primary); font-size: 0.95rem;">{{ $item->title_en }}</strong>
                            @if($item->title_ar)
                                <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 600;">{{ $item->title_ar }}</div>
                            @endif
                        </td>
                        <td><span class="genre-pill">{{ $item->type }}</span></td>
                        <td><strong style="color: var(--text-primary);">{{ $item->total_episodes }}</strong></td>
                        <td>{{ $item->release_year }}</td>
                        <td>
                            <span class="genre-pill" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border-color: rgba(16, 185, 129, 0.35);">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td style="text-align: end;">
                            <div style="display: inline-flex; gap: 0.4rem;">
                                <a href="{{ route('manager.series.episodes', $item) }}" class="btn btn-secondary btn-sm">
                                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>
                                    <span>{{ __('app.episodes') }}</span>
                                </a>
                                <a href="{{ route('manager.series.edit', $item) }}" class="btn btn-secondary btn-sm">
                                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    <span>{{ __('app.edit_series') }}</span>
                                </a>
                                <form action="{{ route('manager.series.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this series?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        {{ $series->links() }}
    </div>
@endsection
