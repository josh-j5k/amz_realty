<?php

namespace App\Http\Controllers;

use App\Helpers\CompressImage;
use Inertia\Inertia;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use App\Http\Resources\ListingResource;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $location = $request->location;

        $status = $request->status;
        if (is_null($status)) {
            $status = 'any';
        }
        $price = [
            'min' => '',
            'max' => ''
        ];
        if (is_null($request->property_type)) {
            $property_type = [];
        } else {
            $property_type = explode('|', $request->property_type);
        }
        if (is_null($request->price) === false) {

            $temPrice = explode('|', $request->price);
            foreach ($temPrice as $item) {
                if (str_starts_with($item, 'over')) {
                    $price['min'] = substr($item, 4);
                } else {
                    $price['max'] = substr($item, 5);
                }
            }
        }
        $query = [
            'location' => $location,
            'status' => $status,
            'price' => $price,
            'property_type' => $property_type
        ];
        if (is_null($request->per_page)) {
            $per_page = 16;
        } else {
            $per_page = (int) $request->per_page;
        }
        $listings = ListingResource::collection(Listing::latest()->filter($query)->paginate($per_page));
        return Inertia::render(
            'Listings/index',
            [
                'query' =>  $query,
                'listings' => $listings

            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Listings/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CompressImage $compressImage)
    {
        $user = $request->user();
        $form_fields = $request->all();
        $form_fields['user_id'] = $user->id;
        $listing = Listing::create($form_fields);

        foreach ($request->inputFiles as $file_input) {
            $folder = date("Y");
            $subFolders = date("m");
            $url = $compressImage->compress($file_input, 1080, 100, $folder, $subFolders);

            ListingImage::create([
                'listing_image' =>  $url,
                'listing_id' => $listing->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {

        $full_listing = new ListingResource($listing);
        return Inertia::render('Listings/show', [
            'listing' => $full_listing
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing, CompressImage $compressImage)
    {
        $form_fields = $request->validate([
            'title' => 'required',
            'location' => 'required',
            'price' => 'required',
            'property_type' => 'required',
            'property_status' => 'required',
            'description' => 'required',
        ]);
        if ($request->deletedImages !== null) {
            foreach ($request->deletedImages as $image) {
                $listing->listingImage()->where('listing_image', $image)->delete();
                $file_path = str_replace("/", "\\", $image);
                unlink(public_path($file_path));
            }
        }
        if ($request->hasFile('inputFiles')) {
            foreach ($request->inputFiles as $file_input) {
                $folder = date("Y");
                $subFolders = date("m");
                $url = $compressImage->compress($file_input, 1080, 100, $folder, $subFolders);

                $listing->listingImage()->updateOrCreate([
                    'listing_image' => $url,
                    'listing_id' => $listing->id
                ]);
            }
        }
        $listing->update($form_fields);
        redirect()->route('user.dashboard', $request->user()->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();
        back();
    }
}
