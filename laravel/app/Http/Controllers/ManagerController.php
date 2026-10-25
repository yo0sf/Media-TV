<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Genre;
use App\Models\Review;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ManagerController extends Controller
{
    public function index()
    {
        $series = Series::with(['genres'])->latest()->paginate(15);
        return view('manager.series_index', compact('series'));
    }

    public function createSeries()
    {
        $genres = Genre::all();
        return view('manager.series_create', compact('genres'));
    }

    public function storeSeries(Request $request)
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'synopsis_en' => ['required', 'string'],
            'synopsis_ar' => ['nullable', 'string'],
            'type' => ['required', 'in:TV,Movie,OVA'],
            'status' => ['required', 'in:Airing,Finished,Upcoming'],
            'total_episodes' => ['required', 'integer', 'min:1'],
            'release_year' => ['required', 'integer', 'min:1960', 'max:2030'],
            'poster_image' => ['nullable', 'string'],
            'poster_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['exists:genres,id'],
        ]);

        if ($request->hasFile('poster_file')) {
            $path = $request->file('poster_file')->store('posters', 'public');
            $validated['poster_image'] = '/storage/' . $path;
        }

        $validated['slug'] = Str::slug($validated['title_en']) . '-' . rand(100, 999);
        $series = Series::create($validated);

        if (!empty($validated['genres'])) {
            $series->genres()->sync($validated['genres']);
        }

        return redirect()->route('manager.series.index')->with('success', 'Series created successfully.');
    }

    public function editSeries(Series $series)
    {
        $genres = Genre::all();
        return view('manager.series_edit', compact('series', 'genres'));
    }

    public function updateSeries(Request $request, Series $series)
    {
        $validated = $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'synopsis_en' => ['required', 'string'],
            'synopsis_ar' => ['nullable', 'string'],
            'type' => ['required', 'in:TV,Movie,OVA'],
            'status' => ['required', 'in:Airing,Finished,Upcoming'],
            'total_episodes' => ['required', 'integer', 'min:1'],
            'release_year' => ['required', 'integer', 'min:1960', 'max:2030'],
            'poster_image' => ['nullable', 'string'],
            'poster_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['exists:genres,id'],
        ]);

        if ($request->hasFile('poster_file')) {
            $path = $request->file('poster_file')->store('posters', 'public');
            $validated['poster_image'] = '/storage/' . $path;
        }

        $series->update($validated);

        if (isset($validated['genres'])) {
            $series->genres()->sync($validated['genres']);
        }

        return redirect()->route('manager.series.index')->with('success', 'Series updated successfully.');
    }

    public function destroySeries(Series $series)
    {
        $series->delete();
        return back()->with('success', 'Series deleted successfully.');
    }

    // Episodes Management
    public function episodes(Series $series)
    {
        $episodes = $series->episodes()->paginate(20);
        return view('manager.episodes', compact('series', 'episodes'));
    }

    public function storeEpisode(Request $request, Series $series)
    {
        $validated = $request->validate([
            'episode_number' => ['required', 'integer', 'min:1'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'air_date' => ['nullable', 'date'],
            'thumbnail_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
            'thumbnail_image' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('episodes', 'public');
            $validated['thumbnail_image'] = '/storage/' . $path;
        }

        $series->episodes()->updateOrCreate(
            ['episode_number' => $validated['episode_number']],
            $validated
        );

        return back()->with('success', 'Episode saved successfully.');
    }

    public function destroyEpisode(Episode $episode)
    {
        $episode->delete();
        return back()->with('success', 'Episode deleted.');
    }

    // Genres Management
    public function genres()
    {
        $genres = Genre::withCount('series')->get();
        return view('manager.genres', compact('genres'));
    }

    public function storeGenre(Request $request)
    {
        $validated = $request->validate([
            'name_en' => ['required', 'string', 'max:100'],
            'name_ar' => ['required', 'string', 'max:100'],
        ]);

        $validated['slug'] = Str::slug($validated['name_en']);
        Genre::updateOrCreate(['slug' => $validated['slug']], $validated);

        return back()->with('success', 'Genre saved.');
    }

    public function destroyGenre(Genre $genre)
    {
        $genre->delete();
        return back()->with('success', 'Genre removed.');
    }

    // Content Moderation
    public function moderation()
    {
        $reviews = Review::with(['user', 'series'])->latest()->paginate(20);
        return view('manager.moderation', compact('reviews'));
    }

    public function toggleReviewApproval(Review $review)
    {
        $review->is_approved = !$review->is_approved;
        $review->save();

        return back()->with('success', 'Review status updated.');
    }

    public function destroyModeratedReview(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review removed.');
    }
}
