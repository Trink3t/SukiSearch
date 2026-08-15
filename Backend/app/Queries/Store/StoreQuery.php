<?php

namespace App\Queries\Store;

use App\Http\Requests\Store\StoreIndexRequest;
use App\Models\Store;
use App\Queries\Store\Sorts\NearestSort;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class StoreQuery extends QueryBuilder
{
    public function __construct(StoreIndexRequest $request)
    {
        parent::__construct(
            Store::query()->with('owner')
        );

        $this
            ->allowedFilters(
                AllowedFilter::partial('name'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('is_open'),
                AllowedFilter::exact('barangay_external_id'),
                AllowedFilter::exact('barangay'),
            )
            ->allowedSorts(
                'name',
                'created_at',
                'status',
                AllowedSort::custom(
                    'nearest',
                    new NearestSort(
                        (float) $request->validated('latitude'),
                        (float) $request->validated('longitude'),
                    )
                ),
            )
            ->defaultSort('-created_at');
    }
}
