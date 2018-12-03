<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\ParseTextFileCommand;
use Illuminate\Support\Facades\Storage;

class ParseTextFileCommandTest extends TestCase
{
    public function testParseTextFileCommandCanTakeAFileAndReturnAnOutputPath()
    {
        $path = realpath(__DIR__. '/../test-fixture.txt');
        $output = file_get_contents(__DIR__. '/../output-fixture.txt', FILE_USE_INCLUDE_PATH);

        $this->artisan('parse:file', [
            'filePath' => $path
        ])
            ->expectsOutput("")
            ->expectsOutput("Complete!")
            ->expectsOutput("report was created at: /storage/report.txt");
    }
}
