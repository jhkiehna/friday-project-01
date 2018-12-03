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

    public function testdocumentHasContent()
    {
        $contents = file_get_contents(__DIR__. '/../test-fixture.txt', FILE_USE_INCLUDE_PATH);

        $this->assertEquals($this->document->getContent(), $contents);
    }

    public function testdocumentCanFindItsTotalNumberOfParagraphs()
    {
        $this->assertEquals($this->document->getParagraphs()->count(), 20);
    }

    public function testdocumentCanFindItsShortestParagraph()
    {
        $shortestParagraph = 'Maecenas et augue urna. Etiam eu tincidunt odio. Cras interdum sapien nec erat elementum, at facilisis neque molestie. Duis at libero quis erat posuere vulputate. Integer lobortis congue vehicula. Nullam auctor, ligula sit amet pretium blandit, enim neque feugiat dolor, eget tempor ante nisi eu sem. Sed ex arcu, accumsan a mattis vitae, consectetur sed eros.';

        $this->assertEquals($this->document->getShortestParagraph(), $shortestParagraph);
        $this->assertEquals(strlen($this->document->getShortestParagraph()), 360);
    }

    public function testdocumentCanFinditsLongestParagraph()
    {
        $longestParagraph = 'Nam justo neque, condimentum sit amet vulputate ut, semper molestie metus. Cras vel metus sollicitudin, ullamcorper orci at, scelerisque urna. Curabitur orci massa, facilisis a ipsum convallis, tincidunt convallis tortor. Quisque ornare congue ex, eu feugiat enim efficitur nec. Duis id est luctus, mattis metus eu, semper mauris. Donec volutpat lacinia turpis, sit amet commodo urna pharetra vel. Nulla auctor risus non neque accumsan, sit amet commodo lectus vulputate. Sed malesuada et ante nec commodo. Nunc volutpat leo feugiat, placerat risus eu, porta dolor. Aliquam venenatis maximus suscipit. Aenean eu metus elementum, tempus felis vel, mollis lorem. Donec bibendum dui mauris, vel congue nisi elementum eget. Proin porta consectetur ligula, ut ultrices risus laoreet non. Morbi sit amet odio ac sapien gravida tincidunt non eu lectus. Nullam at odio at quam gravida vestibulum. Aliquam nisi mi, iaculis ac neque ac, varius egestas turpis.';

        $this->assertEquals($this->document->getLongestParagraph(), $longestParagraph);
        $this->assertEquals(strlen($this->document->getLongestParagraph()), 949);
    }

    public function testdocumentCanFindItsTotalNumberOfSentences()
    {
        $this->assertEquals($this->document->getSentences()->count(), 235);
    }

    public function testdocumentCanFindItsTotalNumberOfWords()
    {
        $this->assertEquals($this->document->getWords()->count(), 1877);
    }

    public function testdocumentCanFindItsTotalNumberOfCharacters()
    {
        $this->assertEquals($this->document->countCharacters(), 12606);
    }

    public function testdocumentCanFindItsAvgNumberOfCharactersPerParagraph()
    {
        $this->assertEquals($this->document->getAverageCharactersPerParagraph(), 630.30);
    }

    public function testdocumentCanFindItsAvgNumberOfSentencesPerParagraph()
    {
        $this->assertEquals($this->document->getAverageSentencesPerParagraph(), 11.75);
    }

    public function testdocumentCanFindItsAvgNumberOfWordsPerParagraph()
    {
        $this->assertEquals($this->document->getAverageWordsPerParagraph(), 93.85);
    }

    public function testdocumentCanFindItsAvgNumberOfWordsPerSentence()
    {
        $this->assertEquals($this->document->getAverageWordsPerSentence(), 7.99);
    }


    public function testCanReturnAListOfOverusedWordsAndTimesUsed()
    {
        $words = [];
        $timesUsed = 0;
        
        $this->assertEquals($words, $this->document->overusedWords());
    }

    public function testDocumentCanReturnAListOfOverusedPhrasesAndTimesUsed()
    {
        $phrases = [];
        $timesUsed = 0;

        $this->assertEquals($phrases, $this->document->overusedPhrases());
    }

    public function testDocumentCanReturnAListOfAlternativesForAnOverusedWord()
    {
        $alternatives = [];

        $this->assertEquals($alternatives, $this->document->wordAlternatives('test'));
    }

    public function testDocumentCanReturnAListOfAlternativesForAnOverusedPhrase()
    {
        $alternatives = [];

        $this->assertEquals($alternatives, $this->document->phraseAlternatives('test placeholder phrase'));
    }

    public function testDocumentCanReturnAListOfSpellingErrors()
    {
        $errors = [];

        $this->assertEquals($errors, $this->document->spellingErrors());
    }

    public function testDocumentCanReturnAListOfGrammarErrors()
    {
        $errors = [];

        $this->assertEquals($errors, $this->document->grammarErrors());
    }
}
