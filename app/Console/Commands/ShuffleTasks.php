<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ShuffleTasks extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'task:shuffle';

    /**
     * The console command description.
     */
    protected $description = 'Shuffles tasks between users';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $userCount = User::count();
        Task::query()->update(['assigned_to' => null]);

        for ($i = 1; $i <= $userCount; $i++) {
            $freeTask = DB::table('tasks')
                ->inRandomOrder()
                ->limit(10);

            $freeTask->update(['assigned_to' => $i]);
        }
    }
}
