<?php

namespace App\Parser;

use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
    public $file;
    public $paragraphs;
    public $sentences;
    public $words;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function parseFile()
    {
        $this->parseParagraphs();

        $this->parseSentences();

        $this->parseWords();

        $this->totalCharacters();
    }

    public function parseParagraphs()
    {
        $this->paragraphs = collect(explode("\n", $this->file))
            ->filter(function ($paragraph) {
                return strlen($paragraph) > 0;
            })
            ->values();
    }

    public function parseSentences()
    {
        $this->sentences = $this->paragraphs->flatmap(function ($paragraph) {
            //Gonna have to figure out a way to make sure punctuation is correct later
            return explode('.', $paragraph);
        })
        ->filter(function ($sentence) {
            return strlen($sentence) > 0;
        })
        ->values();
    }

    public function parseWords()
    {
        $this->words = $this->sentences->flatmap(function ($sentence) {
            return explode(' ', $sentence);
        })
        ->filter(function ($word) {
            return strlen($word) > 0;
        })
        ->values();
    }

    public function totalCharacters()
    {
        //instead of doing a strlen on whole file. I didn't want newline characters counted.
        return $this->paragraphs->reduce(function ($carryCharacters, $paragraph) {
            return $carryCharacters + strlen($paragraph);
        });
    }

    public function shortest()
    {
        
    }
}
