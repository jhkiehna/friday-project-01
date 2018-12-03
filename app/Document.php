<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $filePath;
    protected $content;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->content = file_get_contents($filePath);
    }

    public function getContent()
    {
        return $this->content;
    }

    /********************* 
     * Paragraphs *
    **********************/

    public function getParagraphs()
    {
        return collect(explode("\n", $this->content))
            ->filter(function ($paragraph) {
                return empty(!$paragraph);
            })
            ->values();
    }

    public function getShortestParagraph()
    {
        //This will only return one paragraph. What to do in case of tie?
        return $this->getParagraphs()->reduce(function ($shortestParagraph, $currentParagraph) {
            if (empty($shortestParagraph) || (strlen($currentParagraph) <= strlen($shortestParagraph))) {
                return $currentParagraph;
            }

            return $shortestParagraph;
        });
    }

    public function getLongestParagraph()
    {
        //This will only return one paragraph. What to do in case of tie?
        return $this->getParagraphs()->reduce(function ($longestParagraph, $currentParagraph) {
            if (empty($longestParagraph) || (strlen($currentParagraph) >= strlen($longestParagraph))) {
                return $currentParagraph;
            }

            return $longestParagraph;
        });
    }

    /********************* 
     * Sentences *
    **********************/

    public function getSentences()
    {
        return $this->getParagraphs()
            ->flatMap(function ($paragraph) {
                return collect(preg_split("/[.!?]+[\s]/", $paragraph));
            })
            ->filter(function ($sentence) {
                return empty(!$sentence);
            })
            ->values();
    }

    public function getAverageSentencesPerParagraph()
    {
        return number_format($this->getSentenceCount() / $this->getParagraphCount(), 2);
    }

    /********************* 
     * Words *
    **********************/

    public function getWords()
    {
        return $this->getSentences()
            ->flatMap(function ($sentence) {
                return collect(preg_split("/\W/", $sentence));
            })
            ->filter(function ($word) {
                return empty(!$word);
            })
            ->values();
    }

    public function getAverageWordsPerParagraph()
    {
        return number_format($this->getWordCount() / $this->getParagraphCount(), 2);
    }

    public function getAverageWordsPerSentence()
    {
        return number_format($this->getWordCount() / $this->getSentenceCount(), 2);
    }

    /********************* 
     * Characters *
    **********************/

    public function countCharacters()
    {
        //instead of doing a strlen on whole file. I didn't want newline characters counted.
        return $this->getParagraphs()->reduce(function ($carryCharacters, $paragraph) {
            return $carryCharacters + strlen($paragraph);
        });
    }

    public function getAverageCharactersPerParagraph()
    {
        return number_format($this->getCharacterCount() / $this->getParagraphCount(), 2);
    }
}
