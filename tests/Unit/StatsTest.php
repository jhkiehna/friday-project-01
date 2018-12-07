<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Document;
use App\Stats;

class StatsTest extends TestCase
{
    public $statsObj;
    public $document;

    public function SetUp()
    {
        $path = realpath(__DIR__. '/../test-fixture.txt');
        $this->document = new Document($path);
        $this->statsObj = new Stats($this->document);
    }

    public function testStatsCanBeInitialized()
    {
        $this->assertNotNull($this->statsObj);
        $this->assertNotNull($this->statsObj->numberParagraphs);
        $this->assertNotNull($this->statsObj->shortestParagraph);
    }

    public function testStatsCanFindADocumentsTotalNumberOfParagraphs()
    {
        $this->assertEquals($this->statsObj->numberParagraphs, 20);
    }

    public function testStatsCanFindADocumentsTotalNumberOfSentences()
    {
        $this->assertEquals($this->statsObj->numberSentences, 235);
    }

    public function testStatsCanADocumentsTotalNumberOfWords()
    {
        dd($this->document->getWords());
        $this->assertEquals($this->statsObj->numberWords, 1877);
    }

    public function testStatsCanFindADocumentsTotalNumberOfCharacters()
    {
        $this->assertEquals($this->statsObj->numberCharacters, 12606);
    }

    public function testStatsCanFindADocumentsAvgNumberOfCharactersPerParagraph()
    {
        $this->assertEquals($this->statsObj->averageCharactersPerParagraph, 630.30);
    }

    public function testStatsCanFindADocumentsAvgNumberOfSentencesPerParagraph()
    {
        $this->assertEquals($this->statsObj->averageSentencesPerParagraph, 11.75);
    }

    public function testStatsCanFindADocumentsAvgNumberOfWordsPerParagraph()
    {
        $this->assertEquals($this->statsObj->averageWordsPerParagraph, 93.85);
    }

    public function testStatsCanFindADocumentsAvgNumberOfWordsPerSentence()
    {
        $this->assertEquals($this->statsObj->averageWordsPerSentence, 7.99);
    }

    public function testStatsCanFindADocumentsShortestParagraph()
    {
        $shortestParagraph = 'Maecenas et augue urna. Etiam eu tincidunt odio. Cras interdum sapien nec erat elementum, at facilisis neque molestie. Duis at libero quis erat posuere vulputate. Integer lobortis congue vehicula. Nullam auctor, ligula sit amet pretium blandit, enim neque feugiat dolor, eget tempor ante nisi eu sem. Sed ex arcu, accumsan a mattis vitae, consectetur sed eros.';

        $this->assertEquals($this->statsObj->shortestParagraph, $shortestParagraph);
        $this->assertEquals($this->statsObj->shortestParagraphLength, 360);
    }

    public function testStatsCanFindADocumentsLongestParagraph()
    {
        $longestParagraph = 'Nam justo neque, condimentum sit amet vulputate ut, semper molestie metus. Cras vel metus sollicitudin, ullamcorper orci at, scelerisque urna. Curabitur orci massa, facilisis a ipsum convallis, tincidunt convallis tortor. Quisque ornare congue ex, eu feugiat enim efficitur nec. Duis id est luctus, mattis metus eu, semper mauris. Donec volutpat lacinia turpis, sit amet commodo urna pharetra vel. Nulla auctor risus non neque accumsan, sit amet commodo lectus vulputate. Sed malesuada et ante nec commodo. Nunc volutpat leo feugiat, placerat risus eu, porta dolor. Aliquam venenatis maximus suscipit. Aenean eu metus elementum, tempus felis vel, mollis lorem. Donec bibendum dui mauris, vel congue nisi elementum eget. Proin porta consectetur ligula, ut ultrices risus laoreet non. Morbi sit amet odio ac sapien gravida tincidunt non eu lectus. Nullam at odio at quam gravida vestibulum. Aliquam nisi mi, iaculis ac neque ac, varius egestas turpis.';

        $this->assertEquals($this->statsObj->longestParagraph, $longestParagraph);
        $this->assertEquals($this->statsObj->longestParagraphLength, 949);
    }

    public function testStatsCanFindADocumentsShortestSentence()
    {
        $shortestSentence = 'Duis ac leo augue';

        $this->assertEquals($this->statsObj->shortestSentence, $shortestSentence);
        $this->assertEquals($this->statsObj->shortestSentenceLength, 17);
    }

    public function testStatsCanFindADocumentsLongestSentence()
    {
        $longestSentence = 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vestibulum sit amet purus non nisl efficitur vestibulum sed ut eros.';

        $this->assertEquals($this->statsObj->longestSentence, $longestSentence);
        $this->assertEquals($this->statsObj->longestSentenceLength, 156);
    }

    public function testStatsCanReturnAListOfOverusedWordsAndTimesUsed()
    {
        $rankArray = [
            "sit" => 35,
            "amet" => 35,
            "et" => 30,
            "at" => 30,
            "eu" => 29,
            "vel" => 25,
            "vitae" => 24,
            "sed" => 24,
            "Sed" => 24,
            "nec" => 24,
            "in" => 23,
            "ut" => 21,
            "dolor" => 21,
            "non" => 21,
            "id" => 20,
            "eget" => 20,
        ];
        
        $this->assertEquals($rankArray, $this->statsObj->mostUsedWords);
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

        $this->assertEquals($errors, $this->statsObj->mispellings());
    }

    public function testDocumentCanReturnAListOfGrammarErrors()
    {
        $errors = [];

        $this->assertEquals($errors, $this->document->grammarErrors());
    }
}
