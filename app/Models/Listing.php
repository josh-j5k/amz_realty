<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    use HasFactory;
    use HasUlids;

    public function listingImage(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }
}
