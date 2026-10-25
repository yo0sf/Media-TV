@extends('layouts.app')

@section('title', __('app.content_moderation'))

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.85rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.25rem;">
                {{ __('app.content_moderation') }}
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">
                {{ app()->getLocale() === 'ar' ? 'فحص ومراجعة تعليقات وتقييمات المستخدمين المنشورة' : 'Audit and moderate community ratings and textual reviews.' }}
            </p>
        </div>
        <a href="{{ route('manager.series.index') }}" class="btn btn-secondary btn-sm">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>{{ __('app.manage_catalog') }}</span>
        </a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'المستخدم' : 'User' }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'العمل' : 'Series' }}</th>
                    <th>{{ __('app.score') }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'التعليق والمراجعة' : 'Comment' }}</th>
                    <th>{{ __('app.status') }}</th>
                    <th style="text-align: end;">{{ __('app.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $rev)
                    <tr>
                        <td>{{ $rev->id }}</td>
                        <td><strong style="color: var(--text-primary);">{{ $rev->user->name }}</strong></td>
                        <td>
                            <a href="{{ route('catalog.show', $rev->series->slug) }}" style="color: var(--primary); text-decoration: underline; font-weight: 700;">
                                {{ $rev->series->localized_title }}
                            </a>
                        </td>
                        <td>
                            <span style="color: #f59e0b; font-weight: 800; font-size: 0.92rem; display: inline-flex; align-items: center; gap: 0.2rem;">
                                ★ {{ $rev->rating }}/10
                            </span>
                        </td>
                        <td style="max-width: 340px;">
                            <p style="font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6;">
                                {{ $rev->comment ?? (app()->getLocale() === 'ar' ? '(بدون تعليق نصي)' : '(No text)') }}
                            </p>
                        </td>
                        <td>
                            @if($rev->is_approved)
                                <span class="genre-pill" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border-color: rgba(16, 185, 129, 0.35);">
                                    {{ app()->getLocale() === 'ar' ? 'معتمد' : 'Approved' }}
                                </span>
                            @else
                                <span class="genre-pill" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b; border-color: rgba(245, 158, 11, 0.35);">
                                    {{ app()->getLocale() === 'ar' ? 'معلق' : 'Flagged' }}
                                </span>
                            @endif
                        </td>
                        <td style="text-align: end;">
                            <div style="display: inline-flex; gap: 0.4rem;">
                                <form action="{{ route('manager.moderation.toggle', $rev) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-sm">
                                        {{ $rev->is_approved ? (app()->getLocale() === 'ar' ? 'إخفاء' : 'Hide') : (app()->getLocale() === 'ar' ? 'اعتماد' : 'Approve') }}
                                    </button>
                                </form>

                                <form action="{{ route('manager.moderation.destroy', $rev) }}" method="POST" onsubmit="return confirm('Delete review permanently?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 3rem; font-weight: 600;">
                            {{ app()->getLocale() === 'ar' ? 'لا توجد مراجعات في قائمة الإشراف حالياً.' : 'No reviews found in the moderation queue.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        {{ $reviews->links() }}
    </div>
@endsection
