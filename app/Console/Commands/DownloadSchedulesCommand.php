<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DownloadSchedulesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads schedules from external API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //TODO: Implement downloading schedules
    }
}
