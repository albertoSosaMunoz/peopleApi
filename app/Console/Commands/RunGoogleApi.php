<?php

namespace App\Console\Commands;

use App\Http\Controllers\GoogleApiController;
use Illuminate\Console\Command;

class RunGoogleApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:googleapi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        GoogleApiController::google_api_redirect();
        //GoogleApiController::run();

        return 0;
    }
}
