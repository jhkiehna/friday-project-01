<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Document;

class Report extends Model
{
    protected $document;
    protected $output;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function generate()
    {
        $output = $this->writeStats();

        return $output;
    }

    private function writeStats()
    {
        return "-----\n Stats \n----" .
        "Number of Paragraphs: " .      $this->document->getParagraphs()->count() . " \n" .
        "Number of Sentences: " .       $this->document->getSentences()->count() . " \n" .
        "Number of Words: " .           $this->document->getWords()->count() . " \n" .
        "Number of Characters: " .      $this->document->countCharacters() . " \n\n" .
        
        "Average Sentences per Paragraph: " .      $this->document->getAverageSentencesPerParagraph() . " \n" .
        "Average Words per Paragraph: " .          $this->document->getAverageWordsPerParagraph() . " \n" .
        "Average Words per Sentence: " .           $this->document->getAverageWordsPerSentence() . " \n" .
        "Average Characters per Paragraph: " .     $this->document->getAverageCharactersPerParagraph() . " \n\n" .

        "Longest Paragraph: \n\n" .         $this->document->getLongestParagraph() . " \n\n" .
        "Shortest Paragraph: \n\n" .        $this->document->getShortestParagraph() . " \n\n";
    }
}
