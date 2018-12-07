<?php

namespace App;

use App\Document;

class Report
{
    protected $stats;
    protected $output;

    public function __construct(Document $document)
    {
        $this->stats = $document->getStats();
    }

    public function generate()
    {
        $output = $this->writeStats();

        return $output;
    }

    private function writeStats()
    {
        $output = "-----\n Stats \n-----\n" .
        "Number of Paragraphs: " .      $this->stats->numberParagraphs . " \n" .
        "Number of Sentences: " .       $this->stats->numberSentences . " \n" .
        "Number of Words: " .           $this->stats->numberWords . " \n" .
        "Number of Characters: " .      $this->stats->numberCharacters . " \n\n" .
        
        "Average Sentences per Paragraph: " .      $this->stats->averageSentencesPerParagraph . " \n" .
        "Average Words per Paragraph: " .          $this->stats->averageWordsPerParagraph. " \n" .
        "Average Words per Sentence: " .           $this->stats->averageWordsPerSentence . " \n" .
        "Average Characters per Paragraph: " .     $this->stats->averageCharactersPerParagraph . " \n\n" .

        "Longest Paragraph: " . $this->stats->longestParagraphLength . " :\n\n" . $this->stats->longestParagraph . " \n\n" .
        "Shortest Paragraph: " . $this->stats->shortestParagraphLength . " :\n\n" .        $this->stats->shortestParagraph . " \n\n" .
        "Longest Sentence: " . $this->stats->longestSentenceLength . " :\n\n" . $this->stats->longestSentence . " \n\n" .
        "Shortest Sentence: " . $this->stats->shortestSentenceLength . " :\n\n" .        $this->stats->shortestSentence . " \n\n";

        $misspellings = "Possible Misspellings: \n\n";

        $num = $this->stats->mispellings();

        for($i=0;$i<sizeof($num);$i++){
            $misspellings .= $num[$i] . "\n";
        }

        $output .= $misspellings;

        $mostUsed = "Most Used Words: \n\n";

        $num = $this->stats->getMostUsedWords();

        foreach($num as $key => $value){
            $mostUsed .= $key . " - " . $value ."\n";
        }

        $output .= $mostUsed;

        return $output;
    }
}
