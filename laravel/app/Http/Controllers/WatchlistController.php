<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $query = Auth::user()->watchlists()
            ->with(['series.genres']);

        if ($status) {
            $query->where('status', $status);
        }

        $watchlists = $query->latest('updated_at')->paginate(12)->withQueryString();

        return view('watchlist.index', [
            'watchlists' => $watchlists,
            'currentStatus' => $status,
        ]);
    }

    public function storeOrUpdate(Request $request, Series $series)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Watching,Completed,Plan to Watch,On Hold,Dropped'],
            'progress_episodes' => ['nullable', 'integer', 'min:0', 'max:' . $series->total_episodes],
        ]);

        $progress = $validated['progress_episodes'] ?? 0;
        $status = $validated['status'];

        if ($progress >= $series->total_episodes && $series->total_episodes > 0) {
            $status = 'Completed';
        }

        Watchlist::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'series_id' => $series->id,
            ],
            [
                'status' => $status,
                'progress_episodes' => $progress,
            ]
        );

        return back()->with('success', 'Watchlist updated successfully.');
    }

    public function incrementProgress(Series $series)
    {
        $watchlist = Watchlist::firstOrCreate(
            ['user_id' => Auth::id(), 'series_id' => $series->id],
            ['status' => 'Watching', 'progress_episodes' => 0]
        );

        if ($watchlist->progress_episodes < $series->total_episodes) {
            $watchlist->progress_episodes += 1;
            if ($watchlist->progress_episodes >= $series->total_episodes) {
                $watchlist->status = 'Completed';
            } elseif ($watchlist->status === 'Plan to Watch') {
                $watchlist->status = 'Watching';
            }
            $watchlist->save();
        }

        return back()->with('success', "+1 episode recorded ({$watchlist->progress_episodes}/{$series->total_episodes}).");
    }

    public function decrementProgress(Series $series)
    {
        $watchlist = Watchlist::where('user_id', Auth::id())
            ->where('series_id', $series->id)
            ->first();

        if ($watchlist && $watchlist->progress_episodes > 0) {
            $watchlist->progress_episodes -= 1;
            if ($watchlist->status === 'Completed' && $watchlist->progress_episodes < $series->total_episodes) {
                $watchlist->status = 'Watching';
            }
            $watchlist->save();
        }

        return back()->with('success', 'Episode count decreased.');
    }

    public function destroy(Series $series)
    {
        Watchlist::where('user_id', Auth::id())
            ->where('series_id', $series->id)
            ->delete();

        return back()->with('success', 'Removed from watchlist.');
    }
}
