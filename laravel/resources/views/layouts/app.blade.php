<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Media TV') - {{ __('app.platform_name') }}</title>
    
    <!-- Professional Google Fonts: Cairo for Arabic & Outfit for English -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Anti-flicker theme loader -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('mediatv_theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <style>
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --primary-light: rgba(59, 130, 246, 0.12);
            --accent: #8b5cf6;
            --warning: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --font-family: {{ app()->getLocale() === 'ar' ? "'Cairo', sans-serif" : "'Outfit', sans-serif" }};
        }

        /* Dark Mode High-Contrast Palette */
        [data-theme="dark"] {
            --bg-base: #090e17;
            --bg-surface: #101726;
            --bg-elevated: #172236;
            --border-subtle: #24344e;
            --border-focus: #3b82f6;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --top-nav-bg: rgba(13, 19, 32, 0.94);
            --sidebar-bg: #101726;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.45);
            --card-hover-border: rgba(59, 130, 246, 0.6);
            --hero-gradient: linear-gradient(180deg, rgba(9, 14, 23, 0) 30%, rgba(9, 14, 23, 0.95) 100%);
            --badge-bg: #1e293b;
            --table-hover: rgba(255, 255, 255, 0.03);
            --input-bg: #172236;
        }

        /* Light Mode High-Contrast Palette (WCAG Compliant) */
        [data-theme="light"] {
            --bg-base: #f1f5f9;
            --bg-surface: #ffffff;
            --bg-elevated: #f8fafc;
            --border-subtle: #e2e8f0;
            --border-focus: #3b82f6;
            --text-primary: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --top-nav-bg: rgba(255, 255, 255, 0.96);
            --sidebar-bg: #ffffff;
            --card-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
            --card-hover-border: #3b82f6;
            --hero-gradient: linear-gradient(180deg, rgba(15, 23, 42, 0) 30%, rgba(15, 23, 42, 0.9) 100%);
            --badge-bg: #e2e8f0;
            --table-hover: rgba(15, 23, 42, 0.02);
            --input-bg: #f8fafc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: var(--font-family);
            transition: background-color 0.2s ease, border-color 0.2s ease, color 0.15s ease, box-shadow 0.2s ease;
        }

        /* Arabic Typography Rules */
        html[dir="rtl"] * {
            letter-spacing: 0 !important;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: {{ app()->getLocale() === 'ar' ? '1.75' : '1.6' }};
            text-align: start;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Consistent SVG Icons */
        .svg-icon {
            width: 18px;
            height: 18px;
            display: inline-block;
            vertical-align: middle;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .svg-icon-sm {
            width: 15px;
            height: 15px;
        }

        .svg-icon-lg {
            width: 22px;
            height: 22px;
        }

        /* 1. Header Navigation Bar */
        .portal-topbar {
            background: var(--top-nav-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            padding: 0.65rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .portal-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--primary);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .portal-categories-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            overflow-x: auto;
            padding: 0.2rem 0;
        }

        .category-tab {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.95rem;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 700;
            white-space: nowrap;
            background: var(--bg-elevated);
            color: var(--text-secondary);
            border: 1px solid var(--border-subtle);
            cursor: pointer;
        }

        .category-tab:hover, .category-tab.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            white-space: nowrap;
        }

        .club-login-btn {
            background: #1e3a8a;
            color: #dbeafe;
            border: 1px solid #3b82f6;
            padding: 0.5rem 1.1rem;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }

        [data-theme="light"] .club-login-btn {
            background: #2563eb;
            color: #ffffff;
            border-color: #1d4ed8;
        }

        .club-login-btn:hover {
            background: #1d4ed8;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .icon-btn {
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            color: var(--text-primary);
            padding: 0.5rem 0.8rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            cursor: pointer;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .icon-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .topbar-search-form {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            background: var(--input-bg);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            padding: 0.45rem 1rem;
            color: var(--text-muted);
            transition: all 0.25s ease;
            flex: 1;
            max-width: 520px;
        }

        .topbar-search-form:focus-within {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            color: var(--primary);
        }

        .topbar-search-input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-primary);
            font-size: 0.9rem;
            width: 100%;
        }

        .topbar-search-input:focus {
            width: 250px;
        }

        @media (max-width: 992px) {
            .topbar-search-form {
                display: none;
            }
        }

        /* 2. Three-Column Grid */
        .portal-layout {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 1.5rem;
            max-width: 1720px;
            width: 100%;
            margin: 1.5rem auto;
            padding: 0 1.5rem;
            flex: 1;
        }

        .portal-sidebar-right {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .sidebar-card {
            background: var(--sidebar-bg);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 1.15rem;
            box-shadow: var(--card-shadow);
        }

        .sidebar-title {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.55rem;
            border-bottom: 2px solid var(--border-subtle);
            padding-bottom: 0.55rem;
        }

        .sidebar-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.65rem 0.85rem;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-secondary);
            background: var(--bg-elevated);
            border: 1px solid transparent;
        }

        .sidebar-nav-link:hover, .sidebar-nav-link.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        .sidebar-search-box {
            display: flex;
            gap: 0.4rem;
            margin-bottom: 0.85rem;
        }

        .sidebar-search-input {
            width: 100%;
            padding: 0.6rem 0.85rem;
            background: var(--input-bg);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 0.88rem;
            outline: none;
        }

        .sidebar-search-input:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .portal-main-area {
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
            min-width: 0;
        }

        /* 3. Hero Carousel Banner */
        .hero-featured-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.85rem;
        }

        .featured-card {
            position: relative;
            aspect-ratio: 2 / 3;
            border-radius: var(--radius-md);
            overflow: hidden;
            border: 1px solid var(--border-subtle);
            box-shadow: var(--card-shadow);
        }

        .featured-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .featured-card:hover img {
            transform: scale(1.06);
        }

        .featured-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.1) 35%, rgba(0,0,0,0.95) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 0.95rem;
            color: #ffffff;
        }

        .featured-overlay h3 {
            font-size: 0.92rem;
            font-weight: 800;
            line-height: 1.35;
            margin-bottom: 0.4rem;
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        }

        .featured-overlay .like-btn {
            font-size: 0.78rem;
            color: #cbd5e1;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-weight: 600;
        }

        /* 4. Section Filter Bar */
        .section-header-bar {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 0.75rem 1.15rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            box-shadow: var(--card-shadow);
        }

        .section-tabs {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .section-tab-btn {
            background: var(--bg-elevated);
            color: var(--text-primary);
            border: 1px solid var(--border-subtle);
            padding: 0.45rem 0.95rem;
            border-radius: var(--radius-sm);
            font-size: 0.86rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }

        .section-tab-btn.active, .section-tab-btn:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* 5. Horizontal Scrolling Dedicated Sections */
        .section-block {
            margin-bottom: 2.25rem;
        }

        .section-title-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.95rem;
            padding-bottom: 0.65rem;
            border-bottom: 2px solid var(--border-subtle);
        }

        .section-title-left {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .section-title-heading {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title-badge {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            background: rgba(59, 130, 246, 0.15);
            color: var(--primary);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .section-title-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-view-all {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.35rem 0.75rem;
            border-radius: var(--radius-sm);
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            transition: all 0.2s ease;
        }

        .section-view-all:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
        }

        .scroll-arrow-btn {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            color: var(--text-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .scroll-arrow-btn:hover {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .horizontal-scroll-track {
            display: flex;
            gap: 1.15rem;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            padding: 0.35rem 0.15rem 1rem 0.15rem;
            scrollbar-width: thin;
            scrollbar-color: var(--primary) transparent;
            -webkit-overflow-scrolling: touch;
        }

        .horizontal-scroll-track::-webkit-scrollbar {
            height: 6px;
        }

        .horizontal-scroll-track::-webkit-scrollbar-track {
            background: var(--bg-elevated);
            border-radius: 4px;
        }

        .horizontal-scroll-track::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        .scroll-card {
            flex: 0 0 185px;
            min-width: 185px;
            scroll-snap-align: start;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease, box-shadow 0.25s ease;
            box-shadow: var(--card-shadow);
        }

        .scroll-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.3);
        }

        .scroll-card-thumb {
            position: relative;
            aspect-ratio: 2 / 3;
            background: var(--bg-elevated);
            overflow: hidden;
        }

        .scroll-card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .scroll-card:hover .scroll-card-thumb img {
            transform: scale(1.06);
        }

        .scroll-card-info {
            padding: 0.75rem 0.85rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            gap: 0.4rem;
        }

        .scroll-card-title {
            font-size: 0.88rem;
            font-weight: 800;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: var(--text-primary);
        }

        .scroll-card-sub {
            font-size: 0.76rem;
            color: var(--text-muted);
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            font-weight: 600;
        }

        /* 6. Poster Cards Grid */
        .mycima-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
            gap: 1.15rem;
        }

        .mycima-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.2s ease, box-shadow 0.25s ease;
            box-shadow: var(--card-shadow);
        }

        .mycima-card:hover {
            transform: translateY(-4px);
            border-color: var(--card-hover-border);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.35);
        }

        .mycima-card-thumb {
            position: relative;
            aspect-ratio: 2 / 3;
            background: var(--bg-elevated);
            overflow: hidden;
        }

        .mycima-card-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .mycima-card:hover .mycima-card-thumb img {
            transform: scale(1.05);
        }

        .mycima-badge-ep {
            position: absolute;
            top: 0.55rem;
            inset-inline-start: 0.55rem;
            background: #1e3a8a;
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.5);
            border: 1px solid #3b82f6;
        }

        .mycima-badge-score {
            position: absolute;
            top: 0.55rem;
            inset-inline-end: 0.55rem;
            background: rgba(0, 0, 0, 0.85);
            color: #fbbf24;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .mycima-card-info {
            padding: 0.85rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .mycima-card-title {
            font-size: 0.9rem;
            font-weight: 800;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.45rem;
            color: var(--text-primary);
        }

        .mycima-card-sub {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            font-weight: 600;
        }

        /* Generic Buttons & Inputs */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0.55rem 1.15rem;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--bg-elevated);
            color: var(--text-primary);
            border: 1px solid var(--border-subtle);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #ef4444;
        }

        .btn-danger:hover {
            background: #ef4444;
            color: #ffffff;
        }

        .form-group {
            margin-bottom: 1.15rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.45rem;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.65rem 0.95rem;
            background: var(--input-bg);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 0.9rem;
            outline: none;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--border-focus);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .genre-pill {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid rgba(59, 130, 246, 0.3);
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }

        /* 7. Comprehensive Table & Data Card Styles */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            text-align: start;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .table thead tr {
            background: var(--bg-elevated);
        }

        .table th {
            padding: 1rem 1.25rem;
            font-weight: 800;
            font-size: 0.82rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.03em;
            border-bottom: 2px solid var(--border-subtle);
            white-space: nowrap;
            text-align: start;
        }

        .table td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-subtle);
            color: var(--text-primary);
            text-align: start;
        }

        .table tbody tr {
            transition: background-color 0.15s ease;
        }

        .table tbody tr:hover td {
            background-color: var(--table-hover);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 28px;
            height: 28px;
            padding: 0 0.45rem;
            border-radius: 6px;
            background: var(--bg-elevated);
            border: 1px solid var(--border-subtle);
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 800;
        }

        /* Two columns layout for inner/admin pages */
        .portal-layout.has-two-columns {
            grid-template-columns: 1fr 280px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .portal-layout {
                grid-template-columns: 1fr 280px;
            }
            .portal-layout.has-two-columns {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 860px) {
            .portal-layout {
                grid-template-columns: 1fr;
            }
            .portal-layout.has-two-columns {
                grid-template-columns: 1fr;
            }
            .portal-sidebar-right {
                order: 2;
            }
            .portal-main-area {
                order: 1;
            }
            .hero-featured-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* 8. Custom Pagination Styles */
        .custom-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            padding: 1rem 0;
        }

        .pagination-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.85rem;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-primary);
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .pagination-btn:hover:not(.disabled) {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .pagination-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }

        .pagination-icon {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .pagination-numbers {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .pagination-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 0.35rem;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-secondary);
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .pagination-number:hover:not(.active):not(.dots) {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        .pagination-number.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.35);
        }

        .pagination-number.dots {
            border: none;
            background: transparent;
            cursor: default;
            min-width: 24px;
            color: var(--text-muted);
        }

        /* 9. Clickable Card Overlay (makes entire card thumbnail clickable) */
        .scroll-card-thumb .card-link-overlay,
        .mycima-card-thumb .card-link-overlay,
        .featured-card .card-link-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
        }

        @media (max-width: 480px) {
            .custom-pagination {
                gap: 0.35rem;
            }
            .pagination-btn span {
                display: none;
            }
            .pagination-number {
                min-width: 30px;
                height: 30px;
                font-size: 0.78rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header Navigation -->
    <header class="portal-topbar">
        <!-- Logo -->
        <a href="{{ route('catalog') }}" class="portal-brand">
            <svg class="svg-icon svg-icon-lg" viewBox="0 0 24 24">
                <rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect>
                <polyline points="17 2 12 7 7 2"></polyline>
            </svg>
            <span>{{ __('app.platform_name') }}</span>
        </a>

        <!-- Global Search Bar (Spacious Center) -->
        <form action="{{ route('catalog') }}" method="GET" class="topbar-search-form" role="search">
            <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="{{ __('app.global_search') }}" 
                class="topbar-search-input"
                aria-label="{{ __('app.global_search') }}"
            >
        </form>

        <!-- Top Actions -->
        <div class="topbar-actions">

            <!-- Theme Toggle -->
            <button type="button" class="icon-btn" onclick="toggleTheme()" title="Toggle Theme">
                <span id="theme_icon_container">
                    <svg class="svg-icon" id="theme_moon" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
                    <svg class="svg-icon" id="theme_sun" viewBox="0 0 24 24" style="display:none;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
                </span>
            </button>

            <!-- Language Switcher -->
            @if(app()->getLocale() === 'en')
                <a href="{{ route('locale.switch', 'ar') }}" class="icon-btn">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <span>العربية</span>
                </a>
            @else
                <a href="{{ route('locale.switch', 'en') }}" class="icon-btn">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    <span>English</span>
                </a>
            @endif

            <!-- Auth Actions -->
            @auth
                <a href="{{ route('watchlist.index') }}" class="club-login-btn">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                    <span>{{ __('app.watchlist') }}</span>
                </a>
                <a href="{{ route('profile') }}" class="icon-btn" style="padding: 0.35rem 0.65rem;">
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--primary); flex-shrink: 0;">
                    <span>{{ auth()->user()->name }}</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>{{ __('app.logout') }}</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="club-login-btn">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                    <span>{{ __('app.login') }}</span>
                </a>
            @endauth
        </div>
    </header>

    @php
        $isHomePage = request()->routeIs('catalog') && !request('type') && !request('genre') && !request('search');
        $isAdminArea = request()->routeIs('admin.*') || request()->routeIs('manager.*');
    @endphp

    <!-- Portal Container -->
    <div class="portal-layout {{ !$isHomePage ? 'has-two-columns' : '' }}">


        <!-- Center Main Content -->
        <main class="portal-main-area">
            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: var(--text-primary); padding: 0.85rem 1.15rem; border-radius: var(--radius-sm); font-size: 0.9rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #10b981;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div style="background: rgba(245, 158, 11, 0.15); border: 1px solid #f59e0b; color: var(--text-primary); padding: 0.85rem 1.15rem; border-radius: var(--radius-sm); font-size: 0.9rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24" style="color: #f59e0b;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: var(--text-primary); padding: 0.85rem 1.15rem; border-radius: var(--radius-sm); font-size: 0.9rem;">
                    @foreach($errors->all() as $error)
                        <div>&bull; {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Right Column: Navigation Pages & Search -->
        <aside class="portal-sidebar-right">
            @if($isAdminArea)
                <!-- Admin Dedicated Navigation Widget: Admin Dashboard is FIRST! -->
                <div class="sidebar-card" style="border-top: 3px solid var(--primary);">
                    <div class="sidebar-title">
                        <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--primary);"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'لوحة تحكم الإدارة' : 'Admin Control Panel' }}</span>
                    </div>

                    <ul class="sidebar-nav-list">
                        @if(auth()->check() && auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>{{ __('app.admin_dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="sidebar-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span>{{ __('app.user_management') }}</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a href="{{ route('manager.series.index') }}" class="sidebar-nav-link {{ request()->routeIs('manager.series.index') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                <span>{{ __('app.manager_portal') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('manager.series.create') }}" class="sidebar-nav-link {{ request()->routeIs('manager.series.create') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'إضافة عمل جديد' : 'Add New Series' }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('manager.moderation.index') }}" class="sidebar-nav-link {{ request()->routeIs('manager.moderation.*') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'مراجعة التعليقات' : 'Reviews Moderation' }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('manager.genres.index') }}" class="sidebar-nav-link {{ request()->routeIs('manager.genres.*') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'إدارة التصنيفات' : 'Manage Genres' }}</span>
                            </a>
                        </li>
                        <li style="border-top: 1px solid var(--border-subtle); padding-top: 0.5rem; margin-top: 0.5rem;">
                            <a href="{{ route('profile') }}" class="sidebar-nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'الملف الشخصي' : 'My Profile' }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('catalog') }}" class="sidebar-nav-link">
                                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>{{ __('app.home') }} ({{ __('app.platform_name') }})</span>
                            </a>
                        </li>
                    </ul>
                </div>
            @else
                <!-- Platform Pages Navigation Widget -->
                <div class="sidebar-card">
                    <div class="sidebar-title">
                        <svg class="svg-icon" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span>{{ app()->getLocale() === 'ar' ? 'صفحات المنصة' : 'Navigation Pages' }}</span>
                    </div>

                    <ul class="sidebar-nav-list">
                        @auth
                            @if(auth()->user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" style="background: rgba(59, 130, 246, 0.12); border-color: rgba(59, 130, 246, 0.35); font-weight: 800;">
                                        <svg class="svg-icon" viewBox="0 0 24 24" style="color: var(--primary);"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                        <span>{{ __('app.admin_dashboard') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endauth
                        <li>
                            <a href="{{ route('catalog') }}" class="sidebar-nav-link {{ request()->routeIs('catalog') && !request('type') && !request('genre') && !request('search') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                <span>{{ __('app.home') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('catalog', ['type' => 'TV']) }}" class="sidebar-nav-link {{ request('type') === 'TV' ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'مسلسلات أمريكية (IMDb)' : 'American Series (IMDb)' }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('catalog', ['type' => 'Movie']) }}" class="sidebar-nav-link {{ request('type') === 'Movie' ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect><line x1="7" y1="2" x2="7" y2="22"></line><line x1="17" y1="2" x2="17" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><line x1="2" y1="7" x2="7" y2="7"></line><line x1="2" y1="17" x2="7" y2="17"></line><line x1="17" y1="17" x2="22" y2="17"></line><line x1="17" y1="7" x2="22" y2="7"></line></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'أفلام سينمائية عالمية' : 'Featured Movies' }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('catalog', ['type' => 'anime']) }}" class="sidebar-nav-link {{ request('type') === 'anime' ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>{{ app()->getLocale() === 'ar' ? 'أنمي ياباني (Crunchyroll)' : 'Japanese Anime (Crunchyroll)' }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('watchlist.index') }}" class="sidebar-nav-link {{ request()->routeIs('watchlist.*') ? 'active' : '' }}">
                                <svg class="svg-icon" viewBox="0 0 24 24"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path></svg>
                                <span>{{ __('app.watchlist') }}</span>
                            </a>
                        </li>
                        @auth
                            @if(auth()->user()->isManager() && !auth()->user()->isAdmin())
                                <li>
                                    <a href="{{ route('manager.series.index') }}" class="sidebar-nav-link {{ request()->routeIs('manager.*') ? 'active' : '' }}">
                                        <svg class="svg-icon" viewBox="0 0 24 24"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                        <span>{{ __('app.manager_portal') }}</span>
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            @endif

            <!-- Fast Search In Sidebar Widget (ONLY ON HOME PAGE, GOES OFF ON OTHER PAGES) -->
            @if($isHomePage)
            <div class="sidebar-card">
                <div class="sidebar-title">
                    <svg class="svg-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'البحث السريع' : 'Quick Search' }}</span>
                </div>
                <form action="{{ route('catalog') }}" method="GET" class="sidebar-search-box">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="{{ __('app.search_placeholder') }}" 
                        class="sidebar-search-input"
                    >
                    <button type="submit" class="btn btn-primary" style="padding: 0.6rem 0.85rem;">
                        <svg class="svg-icon svg-icon-sm" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </form>
            </div>
            @endif

            <!-- Family Guide & Age Advisory -->
            <div class="sidebar-card" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(16, 185, 129, 0.08)); border-color: rgba(34, 197, 94, 0.35);">
                <div style="display: flex; align-items: center; gap: 0.65rem; color: #16a34a; font-weight: 800; font-size: 0.88rem;">
                    <svg class="svg-icon" viewBox="0 0 24 24" style="color: #16a34a;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>{{ app()->getLocale() === 'ar' ? 'إرشادات المشاهدة والرقابة الأسرية' : 'Family Guide & Age Advisory' }}</span>
                </div>
            </div>

            <!-- Taxonomy & Genres Cloud -->
            <div class="sidebar-card">
                <div class="sidebar-title">
                    <svg class="svg-icon" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>{{ __('app.all_genres') }}</span>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                    @php $allG = \App\Models\Genre::all(); @endphp
                    @foreach($allG as $g)
                        <a href="{{ route('catalog', ['genre' => $g->slug]) }}" class="category-tab {{ request('genre') === $g->slug ? 'active' : '' }}" style="font-size: 0.78rem; padding: 0.3rem 0.65rem;">
                            {{ $g->localized_name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

    </div>

    <!-- Footer -->
    <footer style="background: var(--top-nav-bg); border-top: 1px solid var(--border-subtle); padding: 2.25rem 1.5rem; text-align: center; color: var(--text-muted); font-size: 0.86rem; margin-top: auto;">
        <p style="font-weight: 700; color: var(--text-primary);">&copy; {{ date('Y') }} {{ __('app.platform_name') }} – Senior Software Engineering University Project.</p>
        <p style="margin-top: 0.35rem; color: var(--text-muted); font-size: 0.82rem;">
            {{ __('app.platform_tagline') }} &bull; High-Contrast Professional UI &bull; Dynamic RTL / LTR
        </p>
    </footer>

    <!-- Theme Mode Switcher -->
    <script>
        function updateThemeIcon(theme) {
            const moon = document.getElementById('theme_moon');
            const sun = document.getElementById('theme_sun');
            if (moon && sun) {
                if (theme === 'light') {
                    moon.style.display = 'none';
                    sun.style.display = 'inline-block';
                } else {
                    moon.style.display = 'inline-block';
                    sun.style.display = 'none';
                }
            }
        }

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme') || 'dark';
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('mediatv_theme', next);
            updateThemeIcon(next);
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateThemeIcon(document.documentElement.getAttribute('data-theme') || 'dark');
        });
    </script>
    @stack('scripts')
</body>
</html>
