@extends('layouts.app')

@section('title', __('app.create_new_series'))

@section('content')
    <div style="max-width: 850px; margin: 0 auto; width: 100%;">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 2.25rem; box-shadow: var(--card-shadow);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 1.25rem;">
                <h1 style="font-size: 1.75rem; font-weight: 900; color: var(--text-primary);">
                    {{ __('app.create_new_series') }}
                </h1>
                <a href="{{ route('manager.series.index') }}" class="btn btn-secondary btn-sm">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span>{{ __('app.cancel') }}</span>
                </a>
            </div>

            <form action="{{ route('manager.series.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'العنوان بالإنجليزية *' : 'Title (English) *' }}</label>
                        <input type="text" name="title_en" value="{{ old('title_en') }}" required class="form-input" placeholder="e.g. Breaking Bad">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ app()->getLocale() === 'ar' ? 'العنوان بالعربية' : 'Title (Arabic)' }}</label>
                        <input type="text" name="title_ar" value="{{ old('title_ar') }}" class="form-input" placeholder="مثال: بريكينغ باد">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'القصة والنبذة بالإنجليزية *' : 'Synopsis (English) *' }}</label>
                    <textarea name="synopsis_en" rows="3" required class="form-textarea" placeholder="Detailed English synopsis...">{{ old('synopsis_en') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'القصة والنبذة بالعربية' : 'Synopsis (Arabic)' }}</label>
                    <textarea name="synopsis_ar" rows="3" class="form-textarea" placeholder="تفاصيل قصة العمل بالعربية...">{{ old('synopsis_ar') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">{{ __('app.type') }} *</label>
                        <select name="type" class="form-select">
                            <option value="TV">TV</option>
                            <option value="Movie">Movie</option>
                            <option value="OVA">OVA</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('app.status') }} *</label>
                        <select name="status" class="form-select">
                            <option value="Finished">Finished</option>
                            <option value="Airing">Airing</option>
                            <option value="Upcoming">Upcoming</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('app.total_episodes') }} *</label>
                        <input type="number" name="total_episodes" min="1" value="{{ old('total_episodes', 12) }}" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label class="form-label">{{ __('app.year') }} *</label>
                        <input type="number" name="release_year" min="1960" max="2030" value="{{ old('release_year', date('Y')) }}" required class="form-input">
                    </div>
                </div>

                <!-- Cover Poster Image Upload & Live Preview -->
                <div class="form-group" style="background: var(--bg-elevated); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                    <label class="form-label" style="font-weight: 800; display: flex; align-items: center; gap: 0.45rem;">
                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'صورة الغلاف والبوستر (رفع ملف أو رابط خارجي)' : 'Cover Poster Image (Upload File or Direct URL)' }}</span>
                    </label>

                    <div style="display: grid; grid-template-columns: 140px 1fr; gap: 1.25rem; align-items: start; margin-top: 0.85rem;">
                        <!-- Live Image Preview Box -->
                        <div style="aspect-ratio: 2 / 3; width: 140px; border-radius: var(--radius-sm); border: 2px dashed var(--border-subtle); background: var(--bg-surface); display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                            <img id="poster_preview" src="" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                            <div id="poster_placeholder" style="text-align: center; color: var(--text-muted); padding: 0.5rem; font-size: 0.78rem;">
                                <svg class="svg-icon" viewBox="0 0 24 24" style="margin: 0 auto 0.4rem; width: 28px; height: 28px; opacity: 0.6;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'معاينة البوستر' : 'Poster Preview' }}</span>
                            </div>
                        </div>

                        <!-- Upload Controls -->
                        <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                            <div>
                                <label style="font-size: 0.82rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.35rem; display: block;">
                                    {{ app()->getLocale() === 'ar' ? 'خيار 1: رفع صورة من الجهاز (PNG, JPG, WEBP)' : 'Option 1: Upload Image File (PNG, JPG, WEBP)' }}
                                </label>
                                <input type="file" name="poster_file" id="poster_file_input" accept="image/*" class="form-input" style="padding: 0.45rem 0.65rem; font-size: 0.85rem;" onchange="previewSelectedFile(this)">
                            </div>

                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="flex: 1; height: 1px; background: var(--border-subtle);"></div>
                                <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700;">{{ app()->getLocale() === 'ar' ? 'أو' : 'OR' }}</span>
                                <div style="flex: 1; height: 1px; background: var(--border-subtle);"></div>
                            </div>

                            <div>
                                <label style="font-size: 0.82rem; font-weight: 700; color: var(--text-secondary); margin-bottom: 0.35rem; display: block;">
                                    {{ app()->getLocale() === 'ar' ? 'خيار 2: لصق رابط صورة مباشر (URL)' : 'Option 2: Direct Image URL (Web Link)' }}
                                </label>
                                <input type="url" name="poster_image" id="poster_url_input" value="{{ old('poster_image') }}" placeholder="https://images.unsplash.com/..." class="form-input" oninput="previewUrlImage(this.value)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ __('app.genres') }}</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 0.6rem; background: var(--bg-elevated); padding: 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                        @foreach($genres as $genre)
                            <label style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.88rem; cursor: pointer; color: var(--text-primary); font-weight: 600;">
                                <input type="checkbox" name="genres[]" value="{{ $genre->id }}">
                                <span>{{ $genre->localized_name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.75rem;">
                    <a href="{{ route('manager.series.index') }}" class="btn btn-secondary">
                        {{ __('app.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        <span>{{ __('app.save') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function previewSelectedFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('poster_preview');
                const placeholder = document.getElementById('poster_placeholder');
                img.src = e.target.result;
                img.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrlImage(url) {
        const img = document.getElementById('poster_preview');
        const placeholder = document.getElementById('poster_placeholder');
        if (url && url.trim().length > 5) {
            img.src = url;
            img.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        }
    }
</script>
@endpush
