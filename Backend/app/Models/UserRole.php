<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
    'user_id',
    'role_id',
])]

#[Table('user_role')]
class UserRole extends Pivot {}
