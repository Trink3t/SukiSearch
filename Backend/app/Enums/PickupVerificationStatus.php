<?php

namespace App\Enums;

enum PickupVerificationStatus: string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
