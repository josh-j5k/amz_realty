<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'listing';
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $listingImg = [];
        $listingImage = ListingImageResource::collection($this->listingImage);
        foreach ($listingImage as $listing_img) {
            array_push($listingImg, $listing_img['listing_image']);
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'location' => $this->location,
            'propertyStatus' => $this->property_status,
            'listingImage' => $listingImg,
            'propertyType' => $this->property_type,
            'price' => $this->price

        ];
    }
}
