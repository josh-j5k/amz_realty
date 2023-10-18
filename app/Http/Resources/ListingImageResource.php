<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingImageResource extends JsonResource
{

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        $listingImg = [];
        foreach ($this as $listimg) {
            // dd($value);
            array_push($listingImg, $listimg['listing_image']);
        }
        return [
            'listingImage' => $listingImg,
        ];
    }
}
