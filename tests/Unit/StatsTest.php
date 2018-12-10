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
        $this->assertEquals($this->statsObj->numberParagraphs, 9);
    }

    public function testStatsCanFindADocumentsTotalNumberOfSentences()
    {
        $this->assertEquals($this->statsObj->numberSentences, 21);
    }

    public function testStatsCanADocumentsTotalNumberOfWords()
    {
        dd($this->document->getWords());
        $this->assertEquals($this->statsObj->numberWords, 1025);
    }

    public function testStatsCanFindADocumentsTotalNumberOfCharacters()
    {
        $this->assertEquals($this->statsObj->numberCharacters, 5815);
    }

    public function testStatsCanFindADocumentsAvgNumberOfCharactersPerParagraph()
    {
        $this->assertEquals($this->statsObj->averageCharactersPerParagraph, 646.11);
    }

    public function testStatsCanFindADocumentsAvgNumberOfSentencesPerParagraph()
    {
        $this->assertEquals($this->statsObj->averageSentencesPerParagraph, 2.33);
    }

    public function testStatsCanFindADocumentsAvgNumberOfWordsPerParagraph()
    {
        $this->assertEquals($this->statsObj->averageWordsPerParagraph, 114);
    }

    public function testStatsCanFindADocumentsAvgNumberOfWordsPerSentence()
    {
        $this->assertEquals($this->statsObj->averageWordsPerSentence, 48.86);
    }

    public function testStatsCanFindADocumentsShortestParagraph()
    {
        $shortestParagraph = 'Chapter I';

        $this->assertEquals($this->statsObj->shortestParagraph, $shortestParagraph);
        $this->assertEquals($this->statsObj->shortestParagraphLength, 9);
    }

    public function testStatsCanFindADocumentsLongestParagraph()
    {
        $longestParagraph = "In England, there was scarcely an amount of order and protection to justify much national boasting. Daring burglaries by armed men, and highway robberies, took place in the capital itself every night; families were publicly cautioned not to go out of town without removing their furniture to upholsterers' warehouses for security; the highwayman in the dark was a City tradesman in the light, and, being recognised and challenged by his fellow- tradesman whom he stopped in his character of \"the Captain,\" gallantly shot him through the head and rode away; the mall was waylaid by seven robbers, and the guard shot three dead, and then got shot dead himself by the other four, \"in consequence of the failure of his ammunition:\" after which the mall was robbed in peace; that magnificent potentate, the Lord Mayor of London, was made to stand and deliver on Turnham Green, by one highwayman, who despoiled the illustrious creature in sight of all his retinue; prisoners in London gaols fought battles with their turnkeys, and the majesty of the law fired blunderbusses in among them, loaded with rounds of shot and ball; thieves snipped off diamond crosses from the necks of noble lords at Court drawing-rooms; musketeers went into St. Giles's, to search for contraband goods, and the mob fired on the musketeers, and the musketeers fired on the mob, and nobody thought any of these occurrences much out of the common way. In the midst of them, the hangman, ever busy and ever worse than useless, was in constant requisition; now, stringing up long rows of miscellaneous criminals; now, hanging a housebreaker on Saturday who had been taken on Tuesday; now, burning people in the hand at Newgate by the dozen, and now burning pamphlets at the door of Westminster Hall; to-day, taking the life of an atrocious murderer, and to-morrow of a wretched pilferer who had robbed a farmer's boy of sixpence.";

        $this->assertEquals($this->statsObj->longestParagraph, $longestParagraph);
        $this->assertEquals($this->statsObj->longestParagraphLength, 1897);
    }

    public function testStatsCanFindADocumentsShortestSentence()
    {
        $shortestSentence = "The Period";

        $this->assertEquals($this->statsObj->shortestSentence, $shortestSentence);
        $this->assertEquals($this->statsObj->shortestSentenceLength, 17);
    }

    public function testStatsCanFindADocumentsLongestSentence()
    {
        $longestSentence = "Daring burglaries by armed men, and highway robberies, took place in the capital itself every night; families were publicly cautioned not to go out of town without removing their furniture to upholsterers' warehouses for security; the highwayman in the dark was a City tradesman in the light, and, being recognised and challenged by his fellow- tradesman whom he stopped in his character of \"the Captain,\" gallantly shot him through the head and rode away; the mall was waylaid by seven robbers, and the guard shot three dead, and then got shot dead himself by the other four, \"in consequence of the failure of his ammunition:\" after which the mall was robbed in peace; that magnificent potentate, the Lord Mayor of London, was made to stand and deliver on Turnham Green, by one highwayman, who despoiled the illustrious creature in sight of all his retinue; prisoners in London gaols fought battles with their turnkeys, and the majesty of the law fired blunderbusses in among them, loaded with rounds of shot and ball; thieves snipped off diamond crosses from the necks of noble lords at Court drawing-rooms; musketeers went into St. Giles's, to search for contraband goods, and the mob fired on the musketeers, and the musketeers fired on the mob, and nobody thought any of these occurrences much out of the common way.";

        $this->assertEquals($this->statsObj->longestSentence, $longestSentence);
        $this->assertEquals($this->statsObj->longestSentenceLength, 1321);
    }

    public function testStatsCanReturnAListOfOverusedWordsAndTimesUsed()
    {
        $rankArray = [
            'in' => 25,
            'the' => 79,
            'of' => 55,
            'and' => 42,
            'to' => 26,
            'a' => 23,
            'was' => 21,
        ];
        
        dd($this->statsObj->mostUsedWords);

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
        $errors = [
            "Southcott",
            "kneeled",
            "sawn",
            "forasmuch",
            "atheistical",
            "Turnham",
            "gaols",
            "Giless",
            "Newgate",
            "Environed",
            "Greatnesses",
          ];

        $this->assertEquals($errors, $this->statsObj->mispellings());
    }

    public function testDocumentCanReturnAListOfGrammarErrors()
    {
        $errors = [];

        $this->assertEquals($errors, $this->document->grammarErrors());
    }
}
