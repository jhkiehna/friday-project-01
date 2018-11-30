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
        $longestParagraph = 'Nam justo neque, condimentum sit amet vulputate ut, semper molestie metus. Cras vel metus sollicitudin, ullamcorper orci at, scelerisque urna. Curabitur orci massa, facilisis a ipsum convallis, tincidunt convallis tortor. Quisque ornare congue ex, eu feugiat enim efficitur nec. Duis id est luctus, mattis metus eu, semper mauris. Donec volutpat lacinia turpis, sit amet commodo urna pharetra vel. Nulla auctor risus non neque accumsan, sit amet commodo lectus vulputate. Sed malesuada et ante nec commodo. Nunc volutpat leo feugiat, placerat risus eu, porta dolor. Aliquam venenatis maximus suscipit. Aenean eu metus elementum, tempus felis vel, mollis lorem. Donec bibendum dui mauris, vel congue nisi elementum eget. Proin porta consectetur ligula, ut ultrices risus laoreet non. Morbi sit amet odio ac sapien gravida tincidunt non eu lectus. Nullam at odio at quam gravida vestibulum. Aliquam nisi mi, iaculis ac neque ac, varius egestas turpis.';

        $result = $parser->longestParagraph();

        $this->assertEquals($result, ['paragraph' => $longestParagraph, 'length' => 949]);
    }

    public function testParserCanFindTotalNumberOfCharacters()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $result = $parser->totalCharacters();

        $this->assertEquals($result, 12606);
    }

    public function testParserCanFindTotalNumberOfWords()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $this->assertEquals($parser->totalWords(), 1877);
    }

    public function testParserCanFindTotalNumberOfSentences()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $this->assertEquals($parser->totalSentences(), 235);
    }

    public function testParserCanFindTotalNumberOfParagraphs()
    {
        $parser = new Parser($this->file);
        $parser->parseFile();

        $this->assertEquals($parser->totalParagraphs(), 20);
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
