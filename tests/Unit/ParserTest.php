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

    public function testParserCanParseTheFile()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $this->assertEquals($parser->paragraphs->count(), 20);
        $this->assertEquals($parser->sentences->count(), 235);
    }

    public function testParserCanFindShortestParagraph()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();
        $shortestParagraph = 'Maecenas et augue urna. Etiam eu tincidunt odio. Cras interdum sapien nec erat elementum, at facilisis neque molestie. Duis at libero quis erat posuere vulputate. Integer lobortis congue vehicula. Nullam auctor, ligula sit amet pretium blandit, enim neque feugiat dolor, eget tempor ante nisi eu sem. Sed ex arcu, accumsan a mattis vitae, consectetur sed eros.';

        $result = $parser->shortestParagraph();

        $this->assertEquals($result, ['paragraph' => $shortestParagraph, 'length' => 360]);
    }

    public function testParserCanFindLongestParagraph()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $result = $parser->longestParagraph();

        $this->assertEquals($result, 10);
    }

    public function testParserCanFindTotalNumberOfCharacters()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $result = $parser->totalCharacters();

        $this->assertEquals($result, 12606);
    }

    public function testParserCanFindTotalNumberOfSentences()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $result = $parser->totalSentences();

        $this->assertEquals($result, 0);
    }

    public function testParserCanFindTotalNumberOfParagraphs()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $result = $parser->totalParagraphs();

        $this->assertEquals($result, 20);
    }

    public function testParserCanFindAverageNumberOfCharactersPerParagraph()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $result = $parser->averageCharacters();

        $this->assertEquals($result, 0);
    }

    public function testParserCanFindAverageNumberOfSentencesPerParagraph()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $result = $parser->averageSentences();

        $this->assertEquals($result, 0);
    }

    public function testParserCanReturnAListOfOverusedWordsAndTimesUsed()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();
        $words = [];
        $timesUsed = 0;

        $result = $parser->overusedWords();
        
        $this->assertEquals($words, $result);
    }

    public function testParserCanReturnAListOfOverusedPhrasesAndTimesUsed()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();
        $phrases = [];
        $timesUsed = 0;

        $result = $parser->overusedPhrases();

        $this->assertEquals($phrases, $result);
    }

    public function testParserCanReturnAListOfAlternativesForAnOverusedWord()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();
        $alternatives = [];

        $result = $parser->wordAlternatives('test');

        $this->assertEquals($alternatives, $result);
    }

    public function testParserCanReturnAListOfAlternativesForAnOverusedPhrase()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();
        $alternatives = [];

        $result = $parser->phraseAlternatives('test placeholder phrase');

        $this->assertEquals($alternatives, $result);
    }

    public function testParserCanReturnAListOfSpellingErrors()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();
        $errors = [];

        $result = $parser->spellingErrors();

        $this->assertEquals($errors, $result);
    }

    public function testParserCanReturnAListOfGrammarErrors()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();
        $errors = [];

        $result = $parser->grammarErrors();

        $this->assertEquals($errors, $result);
    }
}
