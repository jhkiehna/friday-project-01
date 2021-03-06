<?php

namespace App;

use App\Document;

class Stats
{
    private $document;
    private $dictionary;

    public $numberParagraphs;
    public $numberSentences;
    public $numberWords;
    public $numberCharacters;

    public $averageSentencesPerParagraph;
    public $averageWordsPerParagraph;
    public $averageWordsPerSentence;
    public $averageCharactersPerParagraph;

    public $longestParagraph;
    public $longestParagraphLength;
    public $shortestParagraph;
    public $shortestParagraphLength;

    public $longestSentence;
    public $longestSentenceLength;
    public $shortestSentence;
    public $shortestSentenceLength;

    public $mostUsedWords;

    public function __construct(Document $document)
    {
        $this->document = $document;

        $this->initialize();
    }

    private function initialize()
    {
        $this->dictionary = pspell_new("en");

        $this->numberParagraphs     = $this->document->getParagraphs()->count();
        $this->numberSentences      = $this->document->getSentences()->count();
        $this->numberWords          = $this->document->getWords()->count();
        $this->numberCharacters     = $this->countCharacters();

        $this->averageSentencesPerParagraph     = $this->getAverageSentencesPerParagraph();
        $this->averageWordsPerParagraph         = $this->getAverageWordsPerParagraph();
        $this->averageWordsPerSentence          = $this->getAverageWordsPerSentence();
        $this->averageCharactersPerParagraph    = $this->getAverageCharactersPerParagraph();

        $this->longestParagraph = $this->getLongest($this->document->getParagraphs());
        $this->longestParagraphLength = strlen($this->longestParagraph);
        $this->shortestParagraph = $this->getShortest($this->document->getParagraphs());
        $this->shortestParagraphLength = strlen($this->shortestParagraph);

        $this->longestSentence = $this->getLongest($this->document->getSentences());
        $this->longestSentenceLength = strlen($this->longestSentence);
        $this->shortestSentence = $this->getShortest($this->document->getSentences());
        $this->shortestSentenceLength = strlen($this->shortestSentence);

        $this->mostUsedWords = $this->getMostUsedWords();
    }

    private function countCharacters()
    {
        return $this->document->getParagraphs()->reduce(function ($carryCharacters, $paragraph) {
            return $carryCharacters + strlen($paragraph);
        });
    }

    private function getAverageSentencesPerParagraph()
    {
        return number_format($this->numberSentences / $this->numberParagraphs, 2);
    }

    private function getAverageWordsPerParagraph()
    {
        return number_format($this->numberWords / $this->numberParagraphs, 2);
    }

    private function getAverageWordsPerSentence()
    {
        return number_format($this->numberWords / $this->numberSentences, 2);
    }

    private function getAverageCharactersPerParagraph()
    {
        return number_format($this->numberCharacters / $this->numberParagraphs, 2);
    }

    public function getLongest($collection)
    {
        return $collection->reduce(function ($carry, $current) {
            if (empty($carry) || (strlen($current) >= strlen($carry))) {
                return $current;
            }

            return $carry;
        });
    }

    public function getShortest($collection)
    {
        return $collection->reduce(function ($carry, $current) {
            if (empty($carry) || (strlen($current) <= strlen($carry))) {
                return $current;
            }

            return $carry;
        });
    }

    public function getMostUsedWords()
    {
        return collect(freq_dist($this->document->getWords()->toArray())->getKeyValuesByFrequency())
            ->reject(function($item) {
                return $item < 20;
            })
            ->sort()
            ->toArray();
    }

    public function mispellings()
    {
        return $this->document->getWords()->filter(function($word) {
            return !pspell_check($this->dictionary, $word);
        })
        ->values()
        ->toArray();
    }
}
