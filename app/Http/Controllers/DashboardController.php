<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $listings = Listing::where('user_id', $request->user()->id)->with('listingImage')->get();

        return Inertia::render('Dashboard/index', [
            'listings' => $listings
        ]);
    }
    public function messages()
    {
        return Inertia::render('Dashboard/Messages');
    }
    public function saved()
    {
        return Inertia::render('Dashboard/Saved');
    }
}
