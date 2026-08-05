<?php

namespace App\Enums;

enum PickupVerificationMethod: string
{
    case QR_CODE = 'qr_code';
    case PICKUP_CODE = 'pickup_code';
}
