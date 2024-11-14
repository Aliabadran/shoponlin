<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PreferencesController extends Controller
{
    // Show preferences selection form
    public function showPreferences()
    {
        $categories = Category::all(); // Fetch all categories
        $userPreferences = Auth::user()->preferences()->pluck('preference')->toArray(); // Get user's preferences as an array of strings

        return view('home.preferences', compact('categories', 'userPreferences'));
    }

    // Store user preferences
    public function storePreferences(Request $request)
    {
        $user = Auth::user();
        $preferences = $request->input('preferences', []); // Get selected preferences as strings

        // Clear cached ads for this user
        Cache::forget("user_{$user->id}_ads");

        // Clear existing preferences for the user
        $user->preferences()->delete();

        // Store the new preferences
        foreach ($preferences as $preference) {
            $user->preferences()->create(['preference' => $preference, 'score' => 0]); // Assuming score is defaulted to 0
        }
        smilify('success', 'Preferences updated successfully.');
        return redirect()->route('user.ads')->with('success', 'Preferences updated successfully.');
    }
}
