<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Show all the data
    public function index($id)
    {
        // Get all the movies from the specific user
        return Favorite::where('user_id', $id)->orderBy('created_at', 'DESC')->get();
    }

    // Store new entries into the database
    public function store(Request $request)
    {
        // Check if the movie already exists
        $check = Favorite::where(['user_id' => Auth::id(), 'movie_id' => $request->favorite['movie_id']]);
        if ($check) {
            $check->delete();
        }

        // Make a new movie object
        $favorite = new Favorite;

        // Put all the variables in the object
        $favorite->movie_id = $request->favorite['movie_id'];
        $favorite->user_id = Auth::id();
        $favorite->poster = $request->favorite['poster'];
        $favorite->title = $request->favorite['title'];
        $favorite->year = $request->favorite['year'];

        // Save it and return
        $favorite->save();
        return $favorite;
    }

    // Destroy select entries
    public function destroy($id)
    {
        // Find the object
        $favorite = Favorite::where(['user_id' => Auth::id(), 'movie_id' => $id]);

        // Delete the object
        if ($favorite) {
            $favorite->delete();
            return 'Movie deleted';
        }

        return 'Movie not found.';
    }
}
