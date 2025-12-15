<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class DeleteAllSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sessions:delete-all {--force : Force deletion without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all appointments/sessions from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Appointment::count();
        
        if ($count === 0) {
            $this->info('No sessions found to delete.');
            return 0;
        }

        $this->warn("⚠️  WARNING: This will delete ALL {$count} appointments/sessions!");
        $this->warn("This action cannot be undone!");

        if (!$this->option('force')) {
            if (!$this->confirm('Are you sure you want to delete all sessions?', false)) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        $this->info('Deleting all sessions...');

        try {
            DB::beginTransaction();
            
            // Delete all appointments (using forceDelete to bypass soft deletes if any)
            $deleted = Appointment::query()->delete();
            
            DB::commit();
            
            $this->info("✅ Successfully deleted {$deleted} session(s).");
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error deleting sessions: " . $e->getMessage());
            return 1;
        }
    }
}
