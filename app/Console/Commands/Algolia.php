<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\UpdateAlgoliaIndexJob;

class Algolia extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'algolia:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update algolia posts index';

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
     * @return int
     */
    public function handle()
    {
        UpdateAlgoliaIndexJob::dispatch();
        return 0;
    }
}
