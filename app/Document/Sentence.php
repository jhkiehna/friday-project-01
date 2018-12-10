<?php

namespace App\Document;

use TextAnalysis\Tokenizers\SentenceTokenizer;
use App\Document\Word;

class Sentence
{
    public $content;
    public $number;

    public function __construct($content, $number = null)
    {
        $this->content = $content;
        $this->number = $number;
    }

    public function get()
    {
        return $this->sentences();
    }

    public function sentences()
    {
        $sentenceTokenizer = new SentenceTokenizer();

        $sentences = collect($sentenceTokenizer->tokenize($this->content));

        if ($this->number != null) {
            return $sentences->get($this->number - 1);
        }

        return $sentences;
    }

    public function word($number = null)
    {
        $word = new Word($this->sentences($this->number), $number);
        
        return $word;
    }
}
