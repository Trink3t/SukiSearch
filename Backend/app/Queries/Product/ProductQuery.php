<?php

namespace App\Queries\Product;

use App\Models\Product;
use App\Models\Store;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductQuery extends QueryBuilder
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(
            Product::query()
        );

        $this
            ->allowedFilters(
                AllowedFilter::partial('name'),
                AllowedFilter::exact('category_id'),
            )
            ->allowedSorts(
                'name',
                'created_at',
                'updated_at',
                'quantity',
                'price',
            )
            ->defaultSort('-created_at');
    }

    public function withinStore(Store $store): self
    {
        $this->whereBelongsTo($store, 'store');

        return $this;
    }

    public function active(): self
    {
        $this->where('is_active', true);

        return $this;
    }
}
