<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Document\Document;

class DocumentTest extends TestCase
{
    public $document;

    public function SetUp()
    {
        $path = realpath(__DIR__. '/../test-fixture.txt');
        $this->document = new Document($path);
    }

    public function testDocumentCanGetASpecificParagraph()
    {
        $paragraph = 'It was the year of Our Lord one thousand seven hundred and seventy-five. Spiritual revelations were conceded to England at that favoured period, as at this. Mrs. Southcott had recently attained her five-and-twentieth blessed birthday, of whom a prophetic private in the Life Guards had heralded the sublime appearance by announcing that arrangements were made for the swallowing up of London and Westminster. Even the Cock-lane ghost had been laid only a round dozen of years, after rapping out its messages, as the spirits of this very year last past (supernaturally deficient in originality) rapped out theirs. Mere messages in the earthly order of events had lately come to the English Crown and People, from a congress of British subjects in America: which, strange to relate, have proved more important to the human race than any communications yet received through any of the chickens of the Cock-lane brood.';

        $this->assertEquals($paragraph, $this->document->paragraph(4)->get());
    }

    public function testDocumentCanGetASpecificSentenceOfASpecificParagraph()
    {
        $paragraph = 'Spiritual revelations were conceded to England at that favoured period, as at this.';

        $this->assertEquals($paragraph, $this->document->paragraph(4)->sentence(2)->get());
    }

    public function testDocumentCanGetASpecificWordofASpecificSentenceOfASpecificParagraph()
    {
        $word = $this->document->paragraph(4)->sentence(2)->word(2)->get();

        $this->assertEquals($word, 'revelations');
    }

    public function testModelCanGetSpecificInformation()
    {
        $value = $this->document->paragraph(3)->sentence(2)->word(2)->get();

        dd($value);

        $this->assertEquals($word, 'revelations');
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
        $this->assertNotNull($this->document->getSentences());
    }

    public function testDocumentHasWords()
    {
        $this->assertNotNull($this->document->getWords());
    }
}
