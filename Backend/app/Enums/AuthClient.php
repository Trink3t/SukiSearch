<?php

namespace App\Enums;

enum AuthClient: string
{
    case USER = 'client:user';
    case ADMIN = 'client:admin';
}
