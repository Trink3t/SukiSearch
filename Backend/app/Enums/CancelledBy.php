<?php

namespace App\Enums;

enum CancelledBy: string
{
    case CUSTOMER = 'customer';
    case STORE = 'store';
}
