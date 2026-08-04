<?php

namespace App\Enums;

enum ProductAvailability: string
{
    case AVAILABLE = 'available';
    case OUT_OF_STOCK = 'out_of_stock';
    case LOW_STOCK = 'low_stock';
}
