<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListingResource;
use App\Models\Listing;
use Illuminate\Http\Request;


class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  ListingResource::collection(Listing::all());
    }



    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return  new ListingResource($listing);
    }
}
