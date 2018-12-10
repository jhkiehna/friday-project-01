<?php

namespace App\Document;

use App\Document\Content;

class Word
{
    protected $words;

    public function __construct(Content $text)
    {
        $this->words = $this->setWords($text->getContent());
    }

    public function setWords($text)
    {
        return collect(tokenize($text))->map(function($word) {
            return preg_replace("#[[:punct:]]#", "", $word);
        });
    }

    public function getWord($number)
    {
        return $this->words->get($number);
    }

    /**
     * Undocumented function
     *
     * If it receives two paramaters, it takes words at index $x to $y
     * if it receives on paramaters, it takes the first $x words
     * If it receives no paramaters, it returns all words
     * 
     * @param [type] $startOrNumber
     * @param [type] $end
     * @return Collection
     */
    public function getWords($startOrNumber = null, $end = null)
    {
        if (!empty($startOrNumber) && !empty($end)) {
            return $this->words->slice($startOrNumber, $end);
        }

        if (!empty($startOrNumber)) {
            return $this->words->take($startOrNumber);
        }

        return $this->words;
    }
}
