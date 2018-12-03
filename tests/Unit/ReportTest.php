<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Document;
use App\Report;

class ReportTest extends TestCase
{
    public $path;
    public $outputFixture;

    public function SetUp()
    {
        $this->path = realpath(__DIR__.'/test-fixture.txt');

        $this->outputFixture = file_get_contents('output-fixture.txt', FILE_USE_INCLUDE_PATH);
    }

    public function testReportCanGenerateOutput()
    {
        $document = new Document($this->path);
        $report = new Report($document);

        $this->assertEquals($this->outputFixture, $report->generate());
    }
}
