<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class updateCancelPolicyStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancelpolicy:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update cancel policy status if new user register with our website more than 15 days.';

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
        //
    }
}
