<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
    case STORE_OWNER = 'store_owner';
}
