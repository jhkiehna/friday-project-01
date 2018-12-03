<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Parser\Parser;

class ParserTest extends TestCase
{
    protected $parser;

    public function SetUp()
    {
        $path = realpath(__DIR__.'/test-fixture.txt');
        $this->parser = new Parser($path);
        $this->parser->parseFile();
    }

    public function testParserCanParseTheFile()
    {
        $this->assertEquals($this->parser->paragraphs->count(), 20);
        $this->assertEquals($this->parser->sentences->count(), 235);
    }

    public function testParserCanFindShortestParagraph()
    {
        $shortestParagraph = 'Maecenas et augue urna. Etiam eu tincidunt odio. Cras interdum sapien nec erat elementum, at facilisis neque molestie. Duis at libero quis erat posuere vulputate. Integer lobortis congue vehicula. Nullam auctor, ligula sit amet pretium blandit, enim neque feugiat dolor, eget tempor ante nisi eu sem. Sed ex arcu, accumsan a mattis vitae, consectetur sed eros.';

        $result = $this->parser->shortestParagraph();

        $this->assertEquals($result, ['paragraph' => $shortestParagraph, 'length' => 360]);
    }

    public function testParserCanFindLongestParagraph()
    {
        $longestParagraph = 'Nam justo neque, condimentum sit amet vulputate ut, semper molestie metus. Cras vel metus sollicitudin, ullamcorper orci at, scelerisque urna. Curabitur orci massa, facilisis a ipsum convallis, tincidunt convallis tortor. Quisque ornare congue ex, eu feugiat enim efficitur nec. Duis id est luctus, mattis metus eu, semper mauris. Donec volutpat lacinia turpis, sit amet commodo urna pharetra vel. Nulla auctor risus non neque accumsan, sit amet commodo lectus vulputate. Sed malesuada et ante nec commodo. Nunc volutpat leo feugiat, placerat risus eu, porta dolor. Aliquam venenatis maximus suscipit. Aenean eu metus elementum, tempus felis vel, mollis lorem. Donec bibendum dui mauris, vel congue nisi elementum eget. Proin porta consectetur ligula, ut ultrices risus laoreet non. Morbi sit amet odio ac sapien gravida tincidunt non eu lectus. Nullam at odio at quam gravida vestibulum. Aliquam nisi mi, iaculis ac neque ac, varius egestas turpis.';

        $result = $this->parser->longestParagraph();

        $this->assertEquals($result, ['paragraph' => $longestParagraph, 'length' => 949]);
    }

    public function testParserCanFindTotalNumberOfCharacters()
    {
        $result = $this->parser->totalCharacters();

        $this->assertEquals($result, 12606);
    }

    public function testParserCanFindTotalNumberOfWords()
    {
        $this->assertEquals($this->parser->totalWords(), 1877);
    }

    public function testParserCanFindTotalNumberOfSentences()
    {
        $this->assertEquals($this->parser->totalSentences(), 235);
    }

    public function testParserCanFindTotalNumberOfParagraphs()
    {
        $this->assertEquals($this->parser->totalParagraphs(), 20);
    }

    public function testParserCanFindAverageNumberOfCharactersPerParagraph()
    {
        $result = $this->parser->averageCharactersPerParagraph();

        $this->assertEquals($result, 630.3);
    }

    public function testParserCanFindAverageNumberOfWordsPerParagraph()
    {
        $result = $this->parser->averageWordsPerParagraph();

        $this->assertEquals($result, 93.85);
    }

    public function testParserCanFindAverageNumberOfSentencesPerParagraph()
    {
        $result = $this->parser->averageSentencesPerParagraph();

        $this->assertEquals($result, 11.75);
    }

    public function testParserCanReturnAListOfOverusedWordsAndTimesUsed()
    {
        $words = [];
        $timesUsed = 0;

        $result = $this->parser->overusedWords();
        
        $this->assertEquals($words, $result);
    }

    public function testParserCanReturnAListOfOverusedPhrasesAndTimesUsed()
    {
        $phrases = [];
        $timesUsed = 0;

        $result = $this->parser->overusedPhrases();

        $this->assertEquals($phrases, $result);
    }

    public function testParserCanReturnAListOfAlternativesForAnOverusedWord()
    {
        $alternatives = [];

        $result = $this->parser->wordAlternatives('test');

        $this->assertEquals($alternatives, $result);
    }

    public function testParserCanReturnAListOfAlternativesForAnOverusedPhrase()
    {
        $alternatives = [];

        $result = $this->parser->phraseAlternatives('test placeholder phrase');

        $this->assertEquals($alternatives, $result);
    }

    public function testParserCanReturnAListOfSpellingErrors()
    {
        $errors = [];

        $result = $this->parser->spellingErrors();

        $this->assertEquals($errors, $result);
    }

    public function testParserCanReturnAListOfGrammarErrors()
    {
        $errors = [];

        $result = $this->parser->grammarErrors();

        $this->assertEquals($errors, $result);
    }
}
