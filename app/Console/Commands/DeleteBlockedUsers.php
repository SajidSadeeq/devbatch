<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeleteBlockedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete-blocked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete users who have been blocked for 48 hours or longer';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Calculate the date 48 hours ago
    $time = now()->subHours(48);

    // Get the users who are blocked for 48 hours or longer
    $usersToDelete = User::where('is_blocked', true)
        ->where('blocked_at', '<=', $time)
        ->get();

    // Delete the users
    foreach ($usersToDelete as $user) {
        $user->delete();
    }

    $count = count($usersToDelete);

    $this->info("Deleted {$count} users who were blocked for 48 hours or longer.");
    }
}
