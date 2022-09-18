<?php

namespace App\Services;

use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;

class ScheduleParserService
{
    function parseSchedule(array $schedule, int $slotDurationMinutes): array
    {
        $timeSlots = [];
        $schedulesDatePeriod = CarbonPeriod::create($schedule['startDate'], $schedule['endDate']);

        foreach ($schedulesDatePeriod as $date) {
            $slotStart = Carbon::create($date->format('Y-m-d') . ' ' . $schedule['startTime']);
            $slotEnd = $slotStart->copy()->add(CarbonInterval::minutes($slotDurationMinutes));
            $endTime = Carbon::create($date->format('Y-m-d') . ' ' . $schedule['endTime']);
            $breakTimePeriods = $this->getTimeBreakPeriods($schedule, $date);

            while ($endTime->greaterThanOrEqualTo($slotEnd)) {
                if (!$this->overlapsWIthAnyBreak($breakTimePeriods, $slotStart, $slotEnd)) {
                    $timeSlots[] = [
                        'schedule_id' => $schedule['scheduleId'],
                        'employee_id' => $schedule['employeeId'],
                        'employee_name' => $schedule['employeeName'],
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $slotStart->format('Y-m-d H:i:s'),
                        'end_time' => $slotEnd->format('Y-m-d H:i:s'),
                    ];
                }

                $slotStart = $slotStart->copy()->add(CarbonInterval::minutes($slotDurationMinutes));
                $slotEnd = $slotEnd->copy()->add(CarbonInterval::minutes($slotDurationMinutes));
            }
        }

        return $timeSlots;
    }

    private function overlapsWIthAnyBreak(
        array           $breakTimePeriods,
        CarbonInterface $slotStart,
        CarbonInterface $slotEnd): bool
    {
        foreach ($breakTimePeriods as $breakTimePeriod) {
            if ($breakTimePeriod->overlaps($slotStart, $slotEnd)) {
                return true;
            }
        }

        return false;
    }

    private function getTimeBreakPeriods(array $schedule, CarbonInterface $date): array
    {
        $breakTimesPeriods = [];
        $dateString = $date->format('Y-m-d');

        for ($i = 1; $i < 4; $i++) {
            $startBreakKey = $i == 1 ? 'startBreak' : "startBreak{$i}";
            $endBreakKey = $i == 1 ? 'endBreak' : "endBreak{$i}";
            $breakStartTime = $schedule[$startBreakKey];
            $breakEndTime = $schedule[$endBreakKey];

            if ($breakStartTime != '00:00:00') {
                $breakTimesPeriods[] = CarbonPeriod::create(
                    $dateString . ' ' . $breakStartTime,
                    $dateString . ' ' . $breakEndTime,
                );
            }
        }

        return $breakTimesPeriods;
    }
}
