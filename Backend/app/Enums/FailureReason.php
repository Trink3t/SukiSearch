<?php

namespace App\Enums;

enum FailureReason: string
{
    case INVALID_CODE = 'invalid_code';
    case EXPIRED = 'expired';
    case ALREADY_USED = 'already_used';
    case WRONG_STORE = 'wrong_store';
    case WRONG_STATUS = 'wrong_status';
    case UNAUTHORIZED = 'unauthorized';
}
