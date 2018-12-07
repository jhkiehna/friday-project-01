<?php

namespace App;

use App\Stats;
use TextAnalysis\Tokenizers\SentenceTokenizer;

class Document
{
    protected $filePath;
    protected $content;
    protected $paragraphs;
    protected $sentences;
    protected $words;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->content = file_get_contents($filePath);

        $this->setParagraphs();
        $this->setSentences();
        $this->setWords();
    }

    public function getStats()
    {
        return new Stats($this);
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getParagraphs()
    {
        return $this->paragraphs;
    }

    public function getSentences()
    {
        return $this->sentences;
    }

    public function getWords()
    {
        return $this->words;
    }

    public function setParagraphs()
    {
        $this->paragraphs = collect(explode("\n", $this->content))
            ->filter(function ($paragraph) {
                return empty(!$paragraph);
            })
            ->values();
    }

    public function setSentences()
    {
        $sentenceTokenizer = new SentenceTokenizer();

        $this->sentences = collect($sentenceTokenizer->tokenize($this->content));
    }

    public function setWords()
    {
        $this->words = collect(tokenize($this->content))->map(function($word) {
            return preg_replace("#[[:punct:]]#", "", $word);
        });
    }
}
