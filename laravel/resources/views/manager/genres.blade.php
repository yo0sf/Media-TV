@extends('layouts.app')

@section('title', __('app.manage_genres'))

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.85rem; font-weight: 900; color: var(--text-primary); margin-bottom: 0.25rem;">
                {{ __('app.manage_genres') }}
            </h1>
            <p style="color: var(--text-muted); font-size: 0.95rem;">
                {{ app()->getLocale() === 'ar' ? 'إدارة وتخصيص تصنيفات الأنمي والمسلسلات باللغتين' : 'Create and maintain bilingual genres and category tags.' }}
            </p>
        </div>
        <a href="{{ route('manager.series.index') }}" class="btn btn-secondary btn-sm">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>{{ __('app.manage_catalog') }}</span>
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 360px 1fr; gap: 2rem; align-items: start;">
        <!-- Add Genre Form -->
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 1.75rem; box-shadow: var(--card-shadow);">
            <h2 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 1.25rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.45rem;">
                <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>{{ app()->getLocale() === 'ar' ? 'إضافة تصنيف جديد' : 'Add New Category' }}</span>
            </h2>

            <form action="{{ route('manager.genres.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'الاسم بالإنجليزية *' : 'Genre Name (English) *' }}</label>
                    <input type="text" name="name_en" required placeholder="e.g. Psychological" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ app()->getLocale() === 'ar' ? 'اسم التصنيف بالعربية *' : 'Genre Name (Arabic) *' }}</label>
                    <input type="text" name="name_ar" required placeholder="مثال: نفسي" class="form-input">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    <span>{{ __('app.save') }}</span>
                </button>
            </form>
        </div>

        <!-- Genres List Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'الاسم (بالإنجليزية)' : 'Name (EN)' }}</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'الاسم (بالعربية)' : 'Name (AR)' }}</th>
                        <th>Slug</th>
                        <th>{{ app()->getLocale() === 'ar' ? 'عدد الأعمال' : 'Count' }}</th>
                        <th style="text-align: end;">{{ __('app.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($genres as $genre)
                        <tr>
                            <td>{{ $genre->id }}</td>
                            <td><strong style="color: var(--text-primary); font-size: 0.95rem;">{{ $genre->name_en }}</strong></td>
                            <td><strong style="color: var(--text-secondary);">{{ $genre->name_ar }}</strong></td>
                            <td><code style="background: var(--bg-elevated); padding: 0.2rem 0.4rem; border-radius: 4px; font-size: 0.82rem; border: 1px solid var(--border-subtle); color: var(--text-muted);">{{ $genre->slug }}</code></td>
                            <td><span class="genre-pill">{{ $genre->series_count }}</span></td>
                            <td style="text-align: end;">
                                <form action="{{ route('manager.genres.destroy', $genre) }}" method="POST" onsubmit="return confirm('Delete this genre?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
