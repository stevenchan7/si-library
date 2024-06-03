<?php

namespace App\Enums;

enum Status: string
{
    case Pending = 'pending';
    case Ready = 'ready';
    case Taken = 'taken';
    case Returned = 'returned';
    case Canceled = 'canceled';
    case Rejected = 'rejected';
}
