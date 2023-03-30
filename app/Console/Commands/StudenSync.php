<?php

namespace App\Console\Commands;

use App\Import\StudentImport;
use App\Import\SubscribeStudentPractice;
use Illuminate\Console\Command;

class StudenSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pr:ss';

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
        $StudentImport = new StudentImport();
        $StudentImport->run();

        $SubscribeStudentPractice = new SubscribeStudentPractice();
        $SubscribeStudentPractice->run();
        return 0;
    }
}
