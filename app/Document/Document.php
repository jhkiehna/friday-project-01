<?php

namespace App\Document;

use App\Stats;
use TextAnalysis\Tokenizers\SentenceTokenizer;

use App\Document\Content;
use App\Document\Paragraph;
use App\Document\Sentence;

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

        $this->content = new Content(file_get_contents($filePath));
        $this->paragraphs = new Paragraph($this->content);
        $this->sentences = new Sentence($this->content);

        // $this->setWords();
    }

    public function getContent()
    {
        return $this->content->getContent();
    }

    public function getParagraph($number)
    {
        return $this->paragraphs->getParagraph($number);
    }

    public function getParagraphs($startOrNumber = null, $end = null)
    {
        return $this->paragraphs->getParagraphs($startOrNumber, $end);
    }

    public function getSentence($number)
    {
        return $this->sentences->getSentence($number);
    }

    public function getSentences($startOrNumber = null, $end = null)
    {
        return $this->sentences->getSentences($startOrNumber, $end);
    }

    public function getStats()
    {
        return new Stats($this);
    }

    // public function getWords()
    // {
    //     return $this->words;
    // }

    // public function setWords()
    // {
    //     $this->words = collect(tokenize($this->content))->map(function($word) {
    //         return preg_replace("#[[:punct:]]#", "", $word);
    //     });
    // }
}
