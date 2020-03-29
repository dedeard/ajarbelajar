<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteExpiredNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleting expired user notifications.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('notifications')->where('created_at', '<', Carbon::now()->subDays(30)->format('Y-m-d'))->delete();
        $this->info('Clean notification running = ' . now());
    }
}
