<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Document;

class DocumentTest extends TestCase
{
    public $document;

    public function SetUp()
    {
        $path = realpath(__DIR__. '/../test-fixture.txt');
        $this->document = new Document($path);
    }

    public function testDocumentHasContent()
    {
        $contents = file_get_contents(__DIR__. '/../test-fixture.txt', FILE_USE_INCLUDE_PATH);

        $this->assertEquals($this->document->getContent(), $contents);
    }

    public function testDocumentHasParagraphs()
    {
        $this->assertNotNull($this->document->getParagraphs());
    }

    public function testDocumentHasSentences()
    {
        dd($this->document->getSentences());
        $this->assertNotNull($this->document->getSentences());
    }

    public function testDocumentHasWords()
    {
        $this->assertNotNull($this->document->getWords());
    }
}
