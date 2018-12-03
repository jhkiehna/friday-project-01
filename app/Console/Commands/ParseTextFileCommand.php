<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Report;
use App\Document;
use Illuminate\Support\Facades\Storage;

class ParseTextFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:file {filePath}';
    protected $filePath;

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
        if (!$this->setPath()) {
            return;
        };

        $this->line('Opening file at: ' . $this->filePath);

        $reportPath = $this->generateReport();
        $this->line('Complete!');
        $this->line('report was created at: ' . $reportPath);
    }

    public function setPath(){
        //Should probably find out how to reference the app root directory, re '/../../../'
        $this->filePath = realpath(__DIR__ . '/../../../' . $this->argument('filePath'));

        if (empty($this->filePath) || $this->filePath == false) {
            $this->line('Invalid path: ' . $this->argument('filePath'));
            $this->line('No file exists at this location');
            return false;
        }

        return true;
    }

    public function generateReport()
    {
        $document = new Document($this->filePath);
        $report = new Report($document);

        Storage::disk('local')->put('report.txt', $report->generate($document));

        return Storage::disk('local')->url('report.txt');
    }
}
