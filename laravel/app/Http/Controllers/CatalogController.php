<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $genreSlug = $request->input('genre');
        $type = $request->input('type');

        $query = Series::with(['genres', 'reviews'])
            ->withAvg('reviews as average_score', 'rating');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title_en', 'like', "%{$search}%")
                  ->orWhere('title_ar', 'like', "%{$search}%")
                  ->orWhere('synopsis_en', 'like', "%{$search}%")
                  ->orWhere('synopsis_ar', 'like', "%{$search}%");
            });
        }

        if ($genreSlug) {
            $query->whereHas('genres', function ($q) use ($genreSlug) {
                $q->where('slug', $genreSlug);
            });
        }

        if ($type) {
            if ($type === 'anime') {
                $query->whereHas('genres', fn($q) => $q->where('slug', 'shounen'));
            } elseif ($type === 'TV') {
                $query->where('type', 'TV')
                      ->whereDoesntHave('genres', fn($q) => $q->where('slug', 'shounen'));
            } else {
                $query->where('type', $type);
            }
        }

        $series = $query->latest()->paginate(18)->withQueryString();
        $genres = Genre::all();

        // Categorized collections for homepage section-by-section browsing
        $tvSeries = Series::with(['genres', 'reviews'])
            ->withAvg('reviews as average_score', 'rating')
            ->where('type', 'TV')
            ->whereDoesntHave('genres', fn($q) => $q->where('slug', 'shounen'))
            ->latest()
            ->take(12)
            ->get();

        $movies = Series::with(['genres', 'reviews'])
            ->withAvg('reviews as average_score', 'rating')
            ->where('type', 'Movie')
            ->latest()
            ->take(12)
            ->get();

        $anime = Series::with(['genres', 'reviews'])
            ->withAvg('reviews as average_score', 'rating')
            ->whereHas('genres', fn($q) => $q->where('slug', 'shounen'))
            ->latest()
            ->take(12)
            ->get();

        return view('catalog.index', [
            'seriesList' => $series,
            'tvSeries' => $tvSeries,
            'movies' => $movies,
            'anime' => $anime,
            'genres' => $genres,
            'currentSearch' => $search,
            'currentGenre' => $genreSlug,
            'currentType' => $type,
        ]);
    }

    public function show(string $slug)
    {
        $series = Series::where('slug', $slug)
            ->with(['genres', 'episodes', 'reviews.user'])
            ->firstOrFail();

        $userWatchlist = null;
        $userReview = null;

        if (Auth::check()) {
            $userWatchlist = Auth::user()->watchlists()
                ->where('series_id', $series->id)
                ->first();

            $userReview = Auth::user()->reviews()
                ->where('series_id', $series->id)
                ->first();
        }

        return view('catalog.show', [
            'series' => $series,
            'userWatchlist' => $userWatchlist,
            'userReview' => $userReview,
        ]);
    }
}
