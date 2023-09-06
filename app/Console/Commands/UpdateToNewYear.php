<?php

namespace App\Console\Commands;

use App\Import\NewEdYearUpdate;
use Illuminate\Console\Command;

class UpdateToNewYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pr:new_year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $NewEdYearUpdate = new NewEdYearUpdate();
        $NewEdYearUpdate->run();

        return 0;
    }
}
