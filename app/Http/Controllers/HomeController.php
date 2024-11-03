<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $featurePosts = Post::published()->featured()->latest()->take(3)->get();

        $latestPosts = Post::published()->featured()->latest()->take(9)->get();

        return view('home',get_defined_vars());
    }
}
