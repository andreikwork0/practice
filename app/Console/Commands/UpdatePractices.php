<?php

namespace App\Console\Commands;

use App\Import\DGroupImport;
use App\Import\PracticeImport;
use App\Import\PracticeImportStorage;
use App\Import\StudentImport;
use App\Import\SubscribeStudentPractice;
use App\Import\SubscribeTeacherPractice;
use App\Import\TeacherImport;
use Illuminate\Console\Command;

class UpdatePractices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pr:pu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация практик';

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


        // скачать преподов
        $TeacherImport = new TeacherImport();
        $TeacherImport->run();

        $DGroupImport = new DGroupImport();
        $DGroupImport->run();

        $PracticeImport = new PracticeImport();
        $PracticeImport->run();

        $PracticeImportStorage = new PracticeImportStorage();
        $PracticeImportStorage->run();


        $StudentImport = new StudentImport();
        $StudentImport->run();

        $SubscribeStudentPractice = new SubscribeStudentPractice();
        $SubscribeStudentPractice->run();


        $SubscribeTeacherPractice = new SubscribeTeacherPractice();
        $SubscribeTeacherPractice->run();

        return 0;
    }
}
