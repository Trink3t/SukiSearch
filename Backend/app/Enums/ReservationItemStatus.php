<?php

namespace App\Enums;

enum ReservationItemStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case READY_FOR_PICKUP = 'ready_for_pickup';
    case CANCELATION_REQUESTED = 'cancelation_requested';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
