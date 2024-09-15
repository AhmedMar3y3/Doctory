<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;

class DeleteOldReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete reservations older than 1 minute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get reservations older than 1 minute
        $oneMinuteAgo = Carbon::now()->subMinute();
        $reservationsToDelete = Reservation::where('created_at', '<', $oneMinuteAgo)->get();

        if ($reservationsToDelete->count() > 0) {
            // Delete the old reservations
            Reservation::where('created_at', '<', $oneMinuteAgo)->delete();
            $this->info('Deleted ' . $reservationsToDelete->count() . ' reservations older than 1 minute.');
        } else {
            $this->info('No reservations older than 1 minute found.');
        }

        return 0;
    }
}
