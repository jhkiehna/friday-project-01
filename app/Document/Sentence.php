<?php

namespace App\Document;

use TextAnalysis\Tokenizers\SentenceTokenizer;
use App\Document\Content;

class Sentence
{
    protected $sentences;

    public function __construct(Content $text)
    {
        $this->sentences = $this->setSentences($text->getContent());
    }

    private function setSentences($text)
    {
        $sentenceTokenizer = new SentenceTokenizer();

        return collect($sentenceTokenizer->tokenize($text));
    }

    public function getSentence($number)
    {
        return $this->sentences->get($number);
    }

    /**
     * Undocumented function
     *
     * If it receives two paramaters, it takes sentences at index $x to $y
     * if it receives on paramaters, it takes the first $x sentences
     * If it receives no paramaters, it returns all sentences
     * 
     * @param [type] $startOrNumber
     * @param [type] $end
     * @return Collection
     */
    public function getSentences($startOrNumber = null, $end = null)
    {
        if (!empty($startOrNumber) && !empty($end)) {
            return $this->sentences->slice($startOrNumber, $end);
        }

        if (!empty($startOrNumber)) {
            return $this->sentences->take($startOrNumber);
        }

        return $this->sentences;
    }
}
