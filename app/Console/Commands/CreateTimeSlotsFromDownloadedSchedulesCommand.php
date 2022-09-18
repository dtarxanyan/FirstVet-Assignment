<?php

namespace App\Console\Commands;

use App\Repositories\TimeSlotRepository;
use App\Services\ScheduleParserService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use JsonCollectionParser\Parser;

class CreateTimeSlotsFromDownloadedSchedulesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time_slots:create {--fileName=} {--slotDurationMinutes=15}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse downloaded schedule files and store inside DB';

    public function handle(
        Parser                $jsonParser,
        ScheduleParserService $scheduleFileParserService,
        TimeSlotRepository    $timeSlotRepository,
    ): void
    {
        $path = Storage::disk('local')->path($this->option('fileName'));
        $slotDurationMinutes = $this->option('slotDurationMinutes');
        $jsonParser->parse($path, function ($schedule) use (
            $slotDurationMinutes,
            $scheduleFileParserService,
            $timeSlotRepository
        ) {
            $slots = $scheduleFileParserService->parseSchedule($schedule, $slotDurationMinutes);

            $dataToInsert = [];
            $currentTime = Carbon::now();

            foreach ($slots as $slot) {
                $dataToInsert[] = [
                    ...$slot,
                    'created_at' => $currentTime,
                    'updated_at' => $currentTime,
                ];
            }

            $timeSlotRepository->insertSlots($dataToInsert);
        });
    }
}
