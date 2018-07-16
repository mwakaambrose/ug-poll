<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendAutoSurvey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This sends surveys automatically in the back ground';

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
        return redirect()->route('outbox.create');//this runs the script that will send the contious messages
    }
}
