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
    protected $fillable = [
        'title',
        'user_id',
        'property_status',
        'property_type',
        'location',
        'price',
        'description'
    ];

    public function scopeFilter($query, $filters)
    {
        if (is_null($filters['location']) === false) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }
        if ($filters['status'] !== 'any') {
            $query->where('property_status', 'like', '%' . $filters['status'] . '%');
        }
        if (count($filters['property_type']) > 0) {
            foreach ($filters['property_type'] as $key => $value) {
                $query->where('property_type', 'like', '%' . $value . '%');
            }
        }
        if ($filters['price']['min'] !== ''  && $filters['price']['max'] === '') {
            $query->where('price', '>=',  $filters['price']['min']);
        } elseif ($filters['price']['min'] === '' && $filters['price']['max'] !== '') {
            $query->where('price', '<=',  $filters['price']['max']);
        } elseif ($filters['price']['min'] !== ''  && $filters['price']['max'] !== '') {
            $query->whereBetween('price', [$filters['price']['min'], $filters['price']['max']]);
        }
    }
    public function listingImage(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }
}
