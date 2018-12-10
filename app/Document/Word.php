<?php

namespace App\Document;

class Word
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
        return $this->words();
    }

    public function words()
    {
        $words = collect(tokenize($this->content))->map(function($word) {
            return preg_replace("#[[:punct:]]#", "", $word);
        });

        if ($this->number != null) {
            return $words->get($this->number - 1);
        }

        return $words; 
    }
}
