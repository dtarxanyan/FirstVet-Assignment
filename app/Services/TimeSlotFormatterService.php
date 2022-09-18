<?php

namespace App\Services;

use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Collection;

class TimeSlotFormatterService
{
    function toPrettyListFormat(Collection $timeSlots)
    {
        $result = [];

        /** @var TimeSlot $timeSlot */
        foreach ($timeSlots as $timeSlot) {
            $result[] = $timeSlot->date . ' ' . $timeSlot->startTime . ' - ' . $timeSlot->emdTime;
        }
    }
}
