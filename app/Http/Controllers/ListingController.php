<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\User;
use Illuminate\Http\Request;

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

        // $user_data = User::find($request->user()->id)->with('listing');

        $listings = Listing::with('listingImage')->latest()->filter($query)->get();

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
    public function store(Request $request)
    {
        $user = $request->user();
        $form_fields = $request->all();
        $form_fields['user_id'] = $user->id;
        $listing = Listing::create($form_fields);
        function compressImage($original_image, $quality)
        {
            $folder = date("Y");
            $subFolders = date("m");
            $dir = 'images/' . $folder  . '/' . $subFolders;
            if (!is_dir($dir)) {
                mkdir($dir, recursive: true);
            }

            $imageType = getimagesize($original_image)['mime'];
            if ($imageType === 'image/png') {
                $img = imagecreatefrompng($original_image);
            } elseif ($imageType === 'image/jpeg') {
                $img = imagecreatefromjpeg($original_image);
            } elseif ($imageType === 'image/webp') {
                $img = imagecreatefromwebp($original_image);
            }

            $img_name = $original_image->hashName();

            $MAX_WIDTH = 1300;

            imagepalettetotruecolor($img);
            $scale_size = $MAX_WIDTH / getimagesize($original_image)[0];

            $MAX_HEIGHT = getimagesize($original_image)[1] * $scale_size;
            $resized_img = imagescale($img, $MAX_WIDTH, $MAX_HEIGHT);
            imagewebp($resized_img, $dir . '/' . $img_name, $quality);
            imagedestroy($img);
            imagedestroy($resized_img);
            return $img_name;
        }
        foreach ($request->inputFiles as $file_input) {
            $folder = date("Y");
            $subFolders = date("m");
            $image_name = compressImage($file_input, 100);
            $url = 'Images/' . $folder . '/' . $subFolders . '/' . $image_name;
            ListingImage::create([
                'listing_image' => '/' . $url,
                'listing_id' => $listing->id
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        return Inertia::render('Listings/show');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
