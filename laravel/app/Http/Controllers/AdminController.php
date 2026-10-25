<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Role;
use App\Models\Series;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $metrics = [
            'total_users' => User::count(),
            'total_series' => Series::count(),
            'total_watchlists' => Watchlist::count(),
            'total_reviews' => Review::count(),
            'avg_rating' => round(Review::avg('rating') ?? 0, 1),
        ];

        $watchlistStatusBreakdown = Watchlist::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $recentUsers = User::with('role')->latest()->take(5)->get();
        $recentReviews = Review::with(['user', 'series'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('metrics', 'watchlistStatusBreakdown', 'recentUsers', 'recentReviews'));
    }

    public function users()
    {
        $users = User::with('role')->latest()->paginate(20);
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // Prevent admin from revoking their own admin role
        if ($user->id === auth()->id()) {
            return back()->withErrors(['role_id' => 'You cannot alter your own administrative role.']);
        }

        $user->role_id = $validated['role_id'];
        $user->save();

        return back()->with('success', "Updated role for user: {$user->name}.");
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account from the admin panel.']);
        }

        $user->delete();

        return back()->with('success', 'User account deleted.');
    }
}
