<?php

namespace App\Queries\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserQuery extends QueryBuilder
{
    public function __construct()
    {
        parent::__construct(
            User::query()->with('roles')
        );

        $this
            ->allowedFilters(
                AllowedFilter::scope('search'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('email'),
                AllowedFilter::callback(
                    'role',
                    function (Builder $query, mixed $value): void {
                        $roles = is_array($value)
                            ? $value
                            : explode(',', (string) $value);

                        $roles = array_filter(
                            array_map('trim', $roles)
                        );

                        $query->whereHas('roles', function (Builder $roleQuery) use ($roles): void {
                            $roleQuery->whereIn('name', $roles);
                        });
                    })
            )
            ->allowedSorts(
                'first_name',
                'last_name',
                'email',
                'created_at',
            )
            ->allowedIncludes('roles')
            ->defaultSort('-created_at');
    }
}
