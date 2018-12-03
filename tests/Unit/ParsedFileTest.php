<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ParsedFile;

class ParsedFileTest extends TestCase
{
    public $parsedFile;

    public function SetUp()
    {
        $path = realpath(__DIR__.'/test-fixture.txt');
        $this->parsedFile = new ParsedFile($path);
    }

    public function testParsedFileHasContent()
    {
        $contents = file_get_contents('test-fixture.txt', FILE_USE_INCLUDE_PATH);

        $this->assertEquals($this->parsedFile->getContent(), $contents);
    }

    public function testParsedFileCanFindItsTotalNumberOfParagraphs()
    {
        $this->assertEquals($this->parsedFile->getParagraphCount(), 20);
    }

    public function testParsedFileCanFindItsShortestParagraph()
    {
        $shortestParagraph = 'Maecenas et augue urna. Etiam eu tincidunt odio. Cras interdum sapien nec erat elementum, at facilisis neque molestie. Duis at libero quis erat posuere vulputate. Integer lobortis congue vehicula. Nullam auctor, ligula sit amet pretium blandit, enim neque feugiat dolor, eget tempor ante nisi eu sem. Sed ex arcu, accumsan a mattis vitae, consectetur sed eros.';

        $this->assertEquals($this->parsedFile->getShortestParagraph(), $shortestParagraph);
        $this->assertEquals(strlen($this->parsedFile->getShortestParagraph()), 360);
    }

    public function testParsedFileCanFinditsLongestParagraph()
    {
        $longestParagraph = 'Nam justo neque, condimentum sit amet vulputate ut, semper molestie metus. Cras vel metus sollicitudin, ullamcorper orci at, scelerisque urna. Curabitur orci massa, facilisis a ipsum convallis, tincidunt convallis tortor. Quisque ornare congue ex, eu feugiat enim efficitur nec. Duis id est luctus, mattis metus eu, semper mauris. Donec volutpat lacinia turpis, sit amet commodo urna pharetra vel. Nulla auctor risus non neque accumsan, sit amet commodo lectus vulputate. Sed malesuada et ante nec commodo. Nunc volutpat leo feugiat, placerat risus eu, porta dolor. Aliquam venenatis maximus suscipit. Aenean eu metus elementum, tempus felis vel, mollis lorem. Donec bibendum dui mauris, vel congue nisi elementum eget. Proin porta consectetur ligula, ut ultrices risus laoreet non. Morbi sit amet odio ac sapien gravida tincidunt non eu lectus. Nullam at odio at quam gravida vestibulum. Aliquam nisi mi, iaculis ac neque ac, varius egestas turpis.';

        $this->assertEquals($this->parsedFile->getLongestParagraph(), $longestParagraph);
        $this->assertEquals(strlen($this->parsedFile->getLongestParagraph()), 949);
    }

    public function testParsedFileCanFindItsTotalNumberOfSentences()
    {
        $this->assertEquals($this->parsedFile->getSentenceCount(), 235);
    }

    public function testParsedFileCanFindItsTotalNumberOfWords()
    {
        $this->assertEquals($this->parsedFile->getWordCount(), 1877);
    }

    public function testParsedFileCanFindItsTotalNumberOfCharacters()
    {
        $this->assertEquals($this->parsedFile->getCharacterCount(), 12606);
    }

    public function testParsedFileCanFindItsAvgNumberOfCharactersPerParagraph()
    {
        $this->assertEquals($this->parsedFile->getAverageCharactersPerParagraph(), 630.30);
    }

    public function testParsedFileCanFindItsAvgNumberOfSentencesPerParagraph()
    {
        $this->assertEquals($this->parsedFile->getAverageSentencesPerParagraph(), 11.75);
    }

    public function testParsedFileCanFindItsAvgNumberOfWordsPerParagraph()
    {
        $this->assertEquals($this->parsedFile->getAverageWordsPerParagraph(), 93.85);
    }

    public function testParsedFileCanFindItsAvgNumberOfWordsPerSentence()
    {
        $this->assertEquals($this->parsedFile->getAverageWordsPerSentence(), 7.99);
    }




    public function testParserCanReturnAListOfOverusedWordsAndTimesUsed()
    {
        $words = [];
        $timesUsed = 0;

        $result = $this->parsedFile->overusedWords();
        
        $this->assertEquals($words, $result);
    }

    public function testParserCanReturnAListOfOverusedPhrasesAndTimesUsed()
    {
        $phrases = [];
        $timesUsed = 0;

        $result = $this->parsedFile->overusedPhrases();

        $this->assertEquals($phrases, $result);
    }

    public function testParserCanReturnAListOfAlternativesForAnOverusedWord()
    {
        $alternatives = [];

        $result = $this->parsedFile->wordAlternatives('test');

        $this->assertEquals($alternatives, $result);
    }

    public function testParserCanReturnAListOfAlternativesForAnOverusedPhrase()
    {
        $alternatives = [];

        $result = $this->parsedFile->phraseAlternatives('test placeholder phrase');

        $this->assertEquals($alternatives, $result);
    }

    public function testParserCanReturnAListOfSpellingErrors()
    {
        $errors = [];

        $result = $this->parsedFile->spellingErrors();

        $this->assertEquals($errors, $result);
    }

    public function testParserCanReturnAListOfGrammarErrors()
    {
        $errors = [];

        $result = $this->parsedFile->grammarErrors();

        $this->assertEquals($errors, $result);
    }
}
