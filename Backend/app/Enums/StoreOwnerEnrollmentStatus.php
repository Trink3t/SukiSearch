<?php

namespace App\Enums;

enum StoreOwnerEnrollmentStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
