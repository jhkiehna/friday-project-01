<?php

namespace App;

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
        $this->sentences =  $this->getParagraphs()
            ->flatMap(function ($paragraph) {
                return collect(preg_split("/[.!?]+[\s]/", $paragraph));
            })
            ->filter(function ($sentence) {
                return empty(!$sentence);
            })
            ->values();
    }

    public function setWords()
    {
        $this->words = $this->getSentences()
            ->flatMap(function ($sentence) {
                return collect(preg_split("/\W/", $sentence));
            })
            ->filter(function ($word) {
                return empty(!$word);
            })
            ->values();
    }
}
