<?php

namespace App\Models\Traits;
use Illuminate\Database\Query\Builder;

trait ListingQueryScopeFilter
{
    public static function scopeFilter(array $filters, Builder $builder): Builder
    {
        $builder->when(filled($filters['location']), function (Builder $builder) use ($filters): void {
            $builder->where('location', 'like', '%' . $filters['location'] . '%');
        })
            // filter if status
            ->when($filters['status'] !== 'any', function (Builder $builder) use ($filters): void {
                $builder->where('property_status', $filters['status']);
            })
            // filter if property type
            ->when(filled($filters['property_type']), function (Builder $builder) use ($filters): void {
                $builder->whereIn('property_type', $filters['property_type']);
            })
            // filter if price
            ->when(filled($filters['price']), function (Builder $builder) use ($filters): void {
                $builder->when($filters['min'] !== '' && $filters['max'] === '', function (Builder $builder) use ($filters): void {
                    $builder->where('price', '>=', $filters['price']['min']);
                })->when($filters['min'] === '' && $filters['max'] !== '', function (Builder $builder) use ($filters): void {
                    $builder->where('price', '<=', $filters['price']['max']);
                })->when($filters['min'] !== '' && $filters['max'] !== '', function (Builder $builder) use ($filters): void {
                    $builder->whereBetween('price', [$filters['price']['min'], $filters['price']['max']]);
                });
            });
        return $builder;
    }
}