<?php

namespace App\Queries\StoreOwnerEnrollment;

use App\Models\StoreOwnerEnrollment;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StoreOwnerEnrollmentQuery extends QueryBuilder
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(
            StoreOwnerEnrollment::query()->with('user')
        );

        $this->allowedFilters(
            AllowedFilter::exact('id'),
            AllowedFilter::exact('status'),
        )
            ->allowedSorts(
                'created_at',
                'reviewed_at'
            )
            ->allowedSorts(
                'user'
            )
            ->defaultSort('-created_at');
    }
}
