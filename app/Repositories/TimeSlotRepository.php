<?php

namespace App\Repositories;

use App\Models\TimeSlot;
use Illuminate\Support\Facades\DB;

class TimeSlotRepository
{
    /**
     * TODO: Implement filtering, selecting fields and sorting using parameters
     */
    public function getFormattedSlots()
    {
        return TimeSlot::select([
            DB::raw("CONCAT(date, ' ', TIME_FORMAT(start_time, '%H:%i'), ' - ', TIME_FORMAT(end_time, '%H:%i'), ' ', employee_name) slot")
        ])
            ->orderBy("date", 'ASC')
            ->orderBy("start_time", 'ASC')
            ->pluck('slot');
    }

    public function insertSlots(array $slots): void
    {
        DB::table(TimeSlot::TABLE_NAME)->insert($slots);
    }
}
