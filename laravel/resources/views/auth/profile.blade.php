@extends('layouts.app')

@section('title', __('app.profile'))

@section('content')
    <div style="max-width: 620px; margin: 2rem auto; width: 100%;">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 2.25rem; box-shadow: var(--card-shadow);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.75rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 1.25rem;">
                <div>
                    <h1 style="font-size: 1.75rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.25rem;">
                        {{ __('app.profile') }}
                    </h1>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">
                        {{ $user->email }}
                    </p>
                </div>
                <span class="genre-pill" style="font-size: 0.82rem; padding: 0.35rem 0.85rem;">
                    {{ $user->role ? $user->role->localized_name : 'Member' }}
                </span>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Avatar Upload Section -->
                <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1.5rem; background: var(--bg-elevated); padding: 1.15rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                    <img id="avatar_preview" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" style="width: 72px; height: 72px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary); box-shadow: 0 4px 12px rgba(0,0,0,0.25); flex-shrink: 0;">
                    <div style="flex: 1;">
                        <label class="form-label" style="font-size: 0.88rem; font-weight: 800; margin-bottom: 0.35rem;">
                            {{ app()->getLocale() === 'ar' ? 'الصورة الشخصية والحساب (رفع صورة جديدة)' : 'Profile Avatar Image (Upload New Photo)' }}
                        </label>
                        <input type="file" name="avatar_file" accept="image/*" class="form-input" style="padding: 0.4rem 0.65rem; font-size: 0.82rem;" onchange="previewAvatar(this)">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input">
                </div>

                <hr style="border: 0; border-top: 1px dashed var(--border-subtle); margin: 1.75rem 0;">
                <h3 style="font-size: 1.05rem; font-weight: 800; margin-bottom: 1rem; color: var(--text-primary);">
                    {{ app()->getLocale() === 'ar' ? 'تعديل كلمة المرور (اختياري)' : 'Security & Password Update (Optional)' }}
                </h3>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الحالية' : 'Current Password' }}</label>
                    <input type="password" name="current_password" class="form-input" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'كلمة المرور الجديدة' : 'New Password' }}</label>
                    <input type="password" name="new_password" class="form-input" placeholder="••••••••">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.password_confirmation') }}</label>
                    <input type="password" name="new_password_confirmation" class="form-input" placeholder="••••••••">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; margin-top: 0.5rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>{{ __('app.save') }}</span>
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('avatar_preview');
                if (img) {
                    img.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
