<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

enum States: int
{
    case Available = 0;
    case Booked = 1;
}

class TimeSlot extends Model
{
    const TABLE_NAME = 'time_slots';

    protected $table = self::TABLE_NAME;
}
