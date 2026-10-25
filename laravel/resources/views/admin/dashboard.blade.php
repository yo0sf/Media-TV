@extends('layouts.app')

@section('title', __('app.admin_dashboard'))

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.25rem;">
                {{ __('app.admin_dashboard') }}
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">
                {{ app()->getLocale() === 'ar' ? 'نظرة عامة على مؤشرات الأداء وحالة المنصة ومقاييس النظام' : 'Executive system overview, performance analytics, and platform oversight.' }}
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>{{ __('app.user_management') }}</span>
        </a>
    </div>

    <!-- Metric KPI Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--card-shadow); position: relative; overflow: hidden;">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.5rem;">
                <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--primary);"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span style="font-size: 0.88rem; color: var(--text-muted); font-weight: 700;">{{ __('app.total_users') }}</span>
            </div>
            <div style="font-size: 2.5rem; font-weight: 900; color: var(--text-primary); margin-top: 0.25rem;">
                {{ $metrics['total_users'] }}
            </div>
            <div style="font-size: 0.8rem; color: var(--success); margin-top: 0.3rem; font-weight: 700; display: flex; align-items: center; gap: 0.3rem;">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #10b981;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'حسابات مسجلة ومفعلة' : 'Registered Accounts' }}</span>
            </div>
        </div>

        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--card-shadow);">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.5rem;">
                <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--accent);"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>
                <span style="font-size: 0.88rem; color: var(--text-muted); font-weight: 700;">{{ __('app.total_series') }}</span>
            </div>
            <div style="font-size: 2.5rem; font-weight: 900; color: var(--accent); margin-top: 0.25rem;">
                {{ $metrics['total_series'] }}
            </div>
            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.3rem; font-weight: 600;">
                {{ app()->getLocale() === 'ar' ? 'أعمال مفهرسة بالدليل' : 'Published in Catalog' }}
            </div>
        </div>

        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--card-shadow);">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.5rem;">
                <svg class="svg-icon" viewBox="0 0 24 24" style="color: #ec4899;"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                <span style="font-size: 0.88rem; color: var(--text-muted); font-weight: 700;">{{ __('app.total_watchlists') }}</span>
            </div>
            <div style="font-size: 2.5rem; font-weight: 900; color: #ec4899; margin-top: 0.25rem;">
                {{ $metrics['total_watchlists'] }}
            </div>
            <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.3rem; font-weight: 600;">
                {{ app()->getLocale() === 'ar' ? 'متابعات نشطة للمستخدمين' : 'Tracked Across Users' }}
            </div>
        </div>

        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--card-shadow);">
            <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.5rem;">
                <svg class="svg-icon" viewBox="0 0 24 24" style="color: #f59e0b;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <span style="font-size: 0.88rem; color: var(--text-muted); font-weight: 700;">{{ __('app.total_reviews') }}</span>
            </div>
            <div style="font-size: 2.5rem; font-weight: 900; color: #f59e0b; margin-top: 0.25rem;">
                {{ $metrics['total_reviews'] }}
            </div>
            <div style="font-size: 0.8rem; color: #f59e0b; margin-top: 0.3rem; font-weight: 700;">
                {{ app()->getLocale() === 'ar' ? 'متوسط التقييم: ' . $metrics['avg_rating'] . '/10' : 'Avg Score: ' . $metrics['avg_rating'] . '/10' }}
            </div>
        </div>
    </div>

    <!-- Status Breakdown & Recent Activity -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2.5rem;">
        
        <!-- Watchlist Distribution -->
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--card-shadow);">
            <h3 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 1.35rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem;">
                <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--primary);"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'توزيع حالات المشاهدة' : 'Watchlist Lifecycle Distribution' }}</span>
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach(['Watching', 'Completed', 'Plan to Watch', 'On Hold', 'Dropped'] as $status)
                    @php $count = $watchlistStatusBreakdown[$status] ?? 0; @endphp
                    <div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.88rem; margin-bottom: 0.35rem; font-weight: 700;">
                            <span style="color: var(--text-secondary);">{{ __('app.status_' . Str::slug($status, '_')) }}</span>
                            <strong style="color: var(--text-primary);">{{ $count }}</strong>
                        </div>
                        <div style="width: 100%; height: 8px; background: var(--bg-elevated); border: 1px solid var(--border-subtle); border-radius: 4px; overflow: hidden;">
                            <div style="width: {{ $metrics['total_watchlists'] > 0 ? ($count / $metrics['total_watchlists']) * 100 : 0 }}%; height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 4px;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Registered Users -->
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--card-shadow);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.35rem;">
                <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--primary);"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'أحدث الأعضاء المسجلين' : 'Recent Registered Users' }}</span>
                </h3>
                <a href="{{ route('admin.users.index') }}" style="font-size: 0.85rem; color: var(--primary); font-weight: 700; text-decoration: underline;">
                    {{ app()->getLocale() === 'ar' ? 'عرض الكل' : 'View All' }}
                </a>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                @foreach($recentUsers as $u)
                    <div style="background: var(--bg-elevated); padding: 0.85rem 1.15rem; border-radius: var(--radius-sm); display: flex; justify-content: space-between; align-items: center; border: 1px solid var(--border-subtle);">
                        <div>
                            <strong style="color: var(--text-primary); font-size: 0.95rem;">{{ $u->name }}</strong>
                            <div style="font-size: 0.82rem; color: var(--text-muted); font-weight: 600;">{{ $u->email }}</div>
                        </div>
                        <span class="genre-pill">
                            {{ $u->role ? $u->role->localized_name : 'User' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
