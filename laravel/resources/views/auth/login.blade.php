@extends('layouts.app')

@section('title', __('app.login'))

@section('content')
    <div style="max-width: 480px; margin: 2rem auto; width: 100%;">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 2.25rem; box-shadow: var(--card-shadow);">
            <div style="text-align: center; margin-bottom: 1.75rem;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                    <svg class="svg-icon svg-icon-lg" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                </div>
                <h1 style="font-size: 1.75rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.35rem;">
                    {{ __('app.login') }}
                </h1>
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    {{ __('app.platform_name') }} – {{ __('app.platform_tagline') }}
                </p>
            </div>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">{{ __('app.email') }}</label>
                    <input type="email" name="email" id="login_email" value="{{ old('email') }}" required autofocus class="form-input" placeholder="name@domain.com">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.password') }}</label>
                    <input type="password" name="password" id="login_password" required class="form-input" placeholder="••••••••">
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.88rem;">
                    <label style="display: flex; align-items: center; gap: 0.45rem; color: var(--text-secondary); cursor: pointer; font-weight: 600;">
                        <input type="checkbox" name="remember">
                        <span>{{ __('app.remember_me') }}</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                    <span>{{ __('app.login') }}</span>
                </button>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem; color: var(--text-muted);">
                {{ __('app.dont_have_account') }}
                <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 800; text-decoration: underline; margin-inline-start: 0.35rem;">
                    {{ __('app.register') }}
                </a>
            </div>

            <!-- Demo Review Accounts -->
            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px dashed var(--border-subtle);">
                <p style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 0.75rem; text-align: center; font-weight: 700;">
                    {{ app()->getLocale() === 'ar' ? 'بيانات الحسابات التجريبية للمراجعة الجامعية (نقرة واحدة للتعيين):' : 'Demo Test Credentials for Academic Review (1-Click Fill):' }}
                </p>
                <div style="display: flex; flex-direction: column; gap: 0.45rem;">
                    <button type="button" onclick="fillCredentials('admin@mediatv.com', 'password123')" class="btn btn-secondary btn-sm" style="font-size: 0.8rem; justify-content: flex-start;">
                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #f59e0b;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'لوحة الإدارة الكاملة: admin@mediatv.com' : 'Administrator: admin@mediatv.com' }}</span>
                    </button>
                    <button type="button" onclick="fillCredentials('manager@mediatv.com', 'password123')" class="btn btn-secondary btn-sm" style="font-size: 0.8rem; justify-content: flex-start;">
                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: var(--primary);"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'استوديو إدارة المحتوى: manager@mediatv.com' : 'Content Studio: manager@mediatv.com' }}</span>
                    </button>
                    <button type="button" onclick="fillCredentials('user@mediatv.com', 'password123')" class="btn btn-secondary btn-sm" style="font-size: 0.8rem; justify-content: flex-start;">
                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'عضو قياسي ومتابع: user@mediatv.com' : 'Standard Member: user@mediatv.com' }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function fillCredentials(email, pass) {
        document.getElementById('login_email').value = email;
        document.getElementById('login_password').value = pass;
    }
</script>
@endpush
