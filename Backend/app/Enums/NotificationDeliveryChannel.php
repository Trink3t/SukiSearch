<?php

namespace App\Enums;

enum NotificationDeliveryChannel: string
{
    case IN_APP = 'in_app';
    case EMAIL = 'email';
    case SMS = 'sms';
}
