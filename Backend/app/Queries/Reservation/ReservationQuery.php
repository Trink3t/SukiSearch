<?php

namespace App\Queries\Reservation;

use App\Models\Reservation;
use App\Models\User;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReservationQuery extends QueryBuilder
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(
            Reservation::query()
        );

        $this
            ->allowedFilters(
                AllowedFilter::partial('public_id'),
                AllowedFilter::exact('status'),
            )
            ->allowedSorts(
                'expires_at',
                'ready_at',
                'picked_up_at',
                'completed_at',
                'created_at'
            )
            ->defaultSort('-created_at');
    }

    public function userReservations(User $user): QueryBuilder
    {
        $this->whereBelongsTo($user, 'customer');

        return $this;
    }
}
