<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\ParseTextFileCommand;
use Illuminate\Support\Facades\Storage;

class ParseTextFileCommandTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testParseTextFileCommandCanTakeAFileAndReturnAnOutputPath()
    {
        //grab test fixture
        $file = Storage::disk('testing')->get('test-input.txt');

        //create a temp test directory and place fixture there 
        Storage::fake('working-directory');
        Storage::disk('working-directory')->put('test.txt', $file);
        
        //get path of fixture in test directory
        $filePath = Storage::disk('working-directory')->url('test-input.txt');

        //call command, pass path to fixture, expect path to outputfile
        $this->artisan('parse:file', [
            'filePath' => $filePath
        ])
            ->expectsOutput('/storage/output.txt')
            ->expectsOutput('Complete');
    }
}
