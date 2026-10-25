@extends('layouts.app')

@section('title', __('app.user_management'))

@section('content')
    <!-- Admin Breadcrumb & Action Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 0.35rem; font-weight: 700;">
                <a href="{{ route('admin.dashboard') }}" style="color: var(--primary); display: inline-flex; align-items: center; gap: 0.35rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>{{ __('app.admin_dashboard') }}</span>
                </a>
                <span>/</span>
                <span>{{ __('app.user_management') }}</span>
            </div>
            <h1 style="font-size: 2rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.65rem;">
                <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--primary);"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>{{ __('app.user_management') }}</span>
            </h1>
            <p style="color: var(--text-muted); font-size: 0.92rem;">
                {{ app()->getLocale() === 'ar' ? 'إدارة حسابات المستخدمين وصلاحيات الأدوار والتحكم في الوصول للنظام' : 'Manage user identities, assign role privileges, and maintain administrative oversight.' }}
            </p>
        </div>

        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span style="background: var(--bg-surface); border: 1px solid var(--border-subtle); padding: 0.45rem 0.85rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 800; color: var(--primary);">
                {{ $users->total() }} {{ app()->getLocale() === 'ar' ? 'حساب مسجل' : 'Registered Users' }}
            </span>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                <span>{{ __('app.admin_dashboard') }}</span>
            </a>
        </div>
    </div>

    <!-- Structured Data Table Card -->
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 70px; text-align: center;">#</th>
                    <th>{{ __('app.name') }}</th>
                    <th>{{ __('app.email') }}</th>
                    <th style="width: 180px;">{{ __('app.role') }}</th>
                    <th>{{ app()->getLocale() === 'ar' ? 'تاريخ التسجيل' : 'Registered At' }}</th>
                    <th style="width: 130px; text-align: end;">{{ __('app.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td style="text-align: center;">
                            <span class="id-badge">#{{ $user->id }}</span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width: 34px; height: 34px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--border-subtle); flex-shrink: 0;">
                                <div>
                                    <strong style="color: var(--text-primary); font-size: 0.94rem; display: block;">{{ $user->name }}</strong>
                                    @if($user->id === auth()->id())
                                        <span class="genre-pill" style="font-size: 0.68rem; padding: 0.1rem 0.45rem; background: rgba(16, 185, 129, 0.15); color: #059669; border-color: rgba(16, 185, 129, 0.4);">
                                            {{ app()->getLocale() === 'ar' ? 'أنت (حسابك)' : 'You (Current)' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.45rem; color: var(--text-secondary); font-size: 0.88rem;">
                                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: var(--text-muted);"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                <span>{{ $user->email }}</span>
                            </div>
                        </td>
                        <td>
                            <!-- Role change form -->
                            <form action="{{ route('admin.users.role', $user) }}" method="POST" style="display: flex; align-items: center; gap: 0.4rem;">
                                @csrf
                                <select 
                                    name="role_id" 
                                    class="form-select" 
                                    style="padding: 0.4rem 0.75rem; font-size: 0.84rem; font-weight: 700; border-radius: var(--radius-sm); color: var(--text-primary); background-color: var(--bg-elevated); border: 1px solid var(--border-subtle);" 
                                    onchange="this.form.submit()" 
                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}
                                    title="Change role"
                                >
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ $role->localized_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.45rem; color: var(--text-muted); font-size: 0.84rem; font-weight: 600;">
                                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span>{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                        </td>
                        <td style="text-align: end;">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ app()->getLocale() === 'ar' ? 'هل أنت متأكد من حذف هذا الحساب نهائياً؟' : 'Delete this user account permanently?' }}');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.35rem 0.75rem;">
                                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        <span>{{ __('app.delete') }}</span>
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 0.78rem; color: var(--text-muted); font-weight: 700;">{{ app()->getLocale() === 'ar' ? '(الحساب الحالي)' : '(Active)' }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $users->links() }}
    </div>
@endsection
