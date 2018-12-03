<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Report;

class ParseTextFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:file {filePath}';
    protected $filePath;
    protected $report;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses a text file, and outputs some stuff';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        parent::__construct();

        $this->report = $report;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->setPath();
        
        $this->line($this->filePath);
        $this->line('Complete');
    }

    public function setPath(){
        //Should probably find out how to reference the app root directory, re '/../../../'
        $this->filePath = realpath(__DIR__ . '/../../../' . $this->argument('filePath'));

        if (empty($this->filePath)) {
            $this->line('Invalid path: ' . $this->argument('filePath'));
            $this->line('No file exists at this location');
            return false;
        }

        return true;
    }
}
