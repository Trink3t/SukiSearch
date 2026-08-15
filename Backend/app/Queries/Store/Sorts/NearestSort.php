<?php

namespace App\Queries\Store\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\Sorts\Sort;

/**
 * @implements Sort<Model>
 */
class NearestSort implements Sort
{
    public function __construct(
        private readonly float $latitude,
        private readonly float $longitude,
    ) {}

    /**
     * @param  Builder<Model>  $query
     */
    public function __invoke(Builder $query, bool $descending, string $property): void
    {
        $distanceExpression = <<<'SQL'
6371.0 * 2 * ASIN(SQRT(
    POWER(SIN(RADIANS(stores.latitude - ?) / 2), 2)
    + COS(RADIANS(?)) * COS(RADIANS(stores.latitude))
    * POWER(SIN(RADIANS(stores.longitude - ?) / 2), 2)
))
SQL;

        $query
            ->addSelect('stores.*')
            ->selectRaw("{$distanceExpression} AS distance_km", [
                $this->latitude,
                $this->latitude,
                $this->longitude,
            ])
            ->orderByDesc('is_open')
            ->orderBy('distance_km', $descending ? 'desc' : 'asc');
    }
}
