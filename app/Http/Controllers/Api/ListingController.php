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
        return  ListingResource::collection(Listing::latest()->filter($query)->get());
    }



    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return  new ListingResource($listing);
    }
}
