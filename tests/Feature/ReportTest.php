<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Document;
use App\Report;

class ReportTest extends TestCase
{
    public $outputFixture;

    public function SetUp()
    {
        $this->outputFixture = file_get_contents(__DIR__. '/../output-fixture.txt', FILE_USE_INCLUDE_PATH);
    }

    public function testReportCanGenerateOutput()
    {
        $document = new Document(realpath(__DIR__. '/../test-fixture.txt'));
        $report = new Report($document);

        $this->assertEquals($this->outputFixture, $report->generate());
    }
}
