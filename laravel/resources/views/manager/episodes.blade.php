@extends('layouts.app')

@section('title', __('app.manage_episodes') . ' - ' . $series->title_en)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.85rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.25rem;">
                {{ __('app.manage_episodes') }}: {{ $series->title_en }}
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">{{ $series->total_episodes }} {{ __('app.total_episodes') }}</p>
        </div>
        <a href="{{ route('manager.series.index') }}" class="btn btn-secondary btn-sm">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>{{ __('app.manage_catalog') }}</span>
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 360px 1fr; gap: 2rem; align-items: start;">
        <!-- Add Episode Form -->
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--card-shadow);">
            <h2 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 1.25rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.45rem;">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'إضافة / تحديث حلقة' : 'Add / Update Episode' }}</span>
            </h2>

            <form action="{{ route('manager.series.episodes.store', $series) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'رقم الحلقة *' : 'Episode # *' }}</label>
                    <input type="number" name="episode_number" min="1" max="{{ $series->total_episodes }}" required class="form-input" placeholder="e.g. 1">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'العنوان (باللغة الإنجليزية)' : 'Title (English)' }}</label>
                    <input type="text" name="title_en" placeholder="e.g. Pilot / Winter Is Coming" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'العنوان (باللغة العربية)' : 'Title (Arabic)' }}</label>
                    <input type="text" name="title_ar" placeholder="مثال: البداية / الشتاء قادم" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.air_date') }}</label>
                    <input type="date" name="air_date" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'صورة مصغرة للحلقة (اختياري)' : 'Episode Thumbnail Image (Optional)' }}</label>
                    <input type="file" name="thumbnail_file" accept="image/*" class="form-input" style="padding: 0.45rem 0.65rem; font-size: 0.85rem;">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>{{ __('app.save') }}</span>
                </button>
            </form>
        </div>

        <!-- Episodes List -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'العنوان' : 'Title' }}</th>
                        <th>{{ __('app.air_date') }}</th>
                        <th style="text-align: end;">{{ __('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($episodes as $ep)
                        <tr>
                            <td><strong style="color: var(--primary); font-size: 0.95rem;">#{{ $ep->episode_number }}</strong></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    @if($ep->thumbnail_url)
                                        <img src="{{ $ep->thumbnail_url }}" alt="" style="width: 52px; height: 32px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border-subtle); flex-shrink: 0;">
                                    @endif
                                    <div>
                                        <div style="color: var(--text-primary); font-weight: 700;">{{ $ep->title_en ?? 'N/A' }}</div>
                                        @if($ep->title_ar)
                                            <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 600;">{{ $ep->title_ar }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span style="color: var(--text-secondary); font-weight: 600;">{{ $ep->air_date ?? 'N/A' }}</span></td>
                            <td style="text-align: end;">
                                <form action="{{ route('manager.episodes.destroy', $ep) }}" method="POST" onsubmit="return confirm('Delete episode?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 3rem; font-weight: 600;">
                                {{ app()->getLocale() === 'ar' ? 'لم يتم إضافة حلقات لهذا العمل بعد.' : 'No episodes added yet.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
