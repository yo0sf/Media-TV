@extends('layouts.app')

@section('title', __('app.register'))

@section('content')
    <div style="max-width: 500px; margin: 2rem auto; width: 100%;">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 2.25rem; box-shadow: var(--card-shadow);">
            <div style="text-align: center; margin-bottom: 1.75rem;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                    <svg class="svg-icon svg-icon-lg" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                </div>
                <h1 style="font-size: 1.75rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.35rem;">
                    {{ __('app.register') }}
                </h1>
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    {{ __('app.platform_name') }} – {{ __('app.platform_tagline') }}
                </p>
            </div>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">{{ __('app.name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus class="form-input" placeholder="John Doe / طارق المنصور">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="name@domain.com">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.password') }}</label>
                    <input type="password" name="password" required class="form-input" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.password_confirmation') }}</label>
                    <input type="password" name="password_confirmation" required class="form-input" placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; margin-top: 0.5rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                    <span>{{ __('app.register') }}</span>
                </button>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem; color: var(--text-muted);">
                {{ __('app.already_have_account') }}
                <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 800; text-decoration: underline; margin-inline-start: 0.35rem;">
                    {{ __('app.login') }}
                </a>
            </div>
        </div>
    </div>
@endsection
