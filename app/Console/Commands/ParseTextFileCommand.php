<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        //Call parser class
        
        $this->line($this->argument('filePath'));
        $this->line('Complete');
    }
}
