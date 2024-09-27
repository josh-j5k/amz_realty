<?php

namespace App\Models;

use App\Models\Traits\ListingQueryScopeFilter;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Listing extends Model
{
    use HasFactory, HasUuids, ListingQueryScopeFilter;
    protected $fillable = [
        'title',
        'ref',
        'user_id',
        'property_status',
        'property_type',
        'location',
        'price',
        'description'
    ];


    public function uploads(): MorphMany
    {
        return $this->morphMany(Upload::class, 'uploadable');
    }
}
