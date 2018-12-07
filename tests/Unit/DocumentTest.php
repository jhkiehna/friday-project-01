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
        $this->assertEquals($this->document->getParagraphs()->count(), 20);
    }

    public function testDocumentHasSentences()
    {
        $this->assertEquals($this->document->getSentences()->count(), 235);
    }

    public function testDocumentHasWords()
    {
        $this->assertEquals($this->document->getWords()->count(), 1877);
    }
}
