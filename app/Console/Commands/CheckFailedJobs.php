<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Notifications\QueueFailedNotification;

class CheckFailedJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-failed-jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there are failed jobs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Logic to check for failed jobs can be implemented here.
        // For example, you could use the `failed_jobs` table to check for any entries.
        $this->info('Checking for failed jobs...');

        // Placeholder for actual logic
        $failedJobs = \DB::table('failed_jobs')->get();

        if (!$failedJobs->isEmpty()) {
            User::first()->notify(new QueueFailedNotification());
        }

        $this->info('Check completed.');
    }
}
