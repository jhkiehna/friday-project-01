<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use App\Parser\Parser;

class ParserTest extends TestCase
{
    protected $file;

    public function SetUp()
    {
        $this->file = file_get_contents('test-fixture.txt', FILE_USE_INCLUDE_PATH);
    }

    public function testParserCanFindShortestParagraph()
    {
        $parser = new Parser($this->file);

        $result = $parser->shortest();

        $this->assertEquals($result, 15);
    }

    public function testParserCanFindLongestParagraph()
    {
        $parser = new Parser($this->file);

        $result = $parser->longest();

        $this->assertEquals($result, 10);
    }

    public function testParserCanFindTotalNumberOfCharacters()
    {
        $parser = new Parser($this->file);

        $result = $parser->totalCharacters();

        $this->assertEquals($result, 12645);
    }

    public function testParserCanFindTotalNumberOfSentences()
    {
        $parser = new Parser($this->file);

        $result = $parser->totalSentences();

        $this->assertEquals($result, 0);
    }

    public function testParserCanFindTotalNumberOfParagraphs()
    {
        $parser = new Parser($this->file);

        $result = $parser->totalParagraphs();

        $this->assertEquals($result, 20);
    }

    public function testParserCanFindAverageNumberOfCharactersPerParagraph()
    {
        $parser = new Parser($this->file);

        $result = $parser->averageCharacters();

        $this->assertEquals($result, 0);
    }

    public function testParserCanFindAverageNumberOfSentencesPerParagraph()
    {
        $parser = new Parser($this->file);

        $result = $parser->averageSentences();

        $this->assertEquals($result, 0);
    }

    public function testParserCanReturnAListOfOverusedWordsAndTimesUsed()
    {
        $parser = new Parser($this->file);
        $words = [];
        $timesUsed = 0;

        $result = $parser->overusedWords();
        
        $this->assertEquals($words, $result);
    }

    public function testParserCanReturnAListOfOverusedPhrasesAndTimesUsed()
    {
        $parser = new Parser($this->file);
        $phrases = [];
        $timesUsed = 0;

        $result = $parser->overusedPhrases();

        $this->assertEquals($phrases, $result);
    }

    public function testParserCanReturnAListOfAlternativesForAnOverusedWord()
    {
        $alternatives = [];

        $result = $parser->wordAlternatives('test');

        $this->assertEquals($alternatives, $result);
    }

    public function testParserCanReturnAListOfAlternativesForAnOverusedPhrase()
    {
        $alternatives = [];

        $result = $parser->phraseAlternatives('test placeholder phrase');

        $this->assertEquals($alternatives, $result);
    }

    public function testParserCanReturnAListOfSpellingErrors()
    {
        $errors = [];

        $result = $parser->spellingErrors();

        $this->assertEquals($errors, $result);
    }

    public function testParserCanReturnAListOfGrammarErrors()
    {
        $errors = [];

        $result = $parser->grammarErrors();

        $this->assertEquals($errors, $result);
    }
}
