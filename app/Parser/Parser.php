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

    public function totalWords()
    {
        return $this->words->count();
    }

    public function totalSentences()
    {
        return $this->sentences->count();
    }

    public function totalParagraphs()
    {
        return $this->paragraphs->count();
    }

    public function averageCharactersPerParagraph()
    {
        $totalCharacters = $this->paragraphs->reduce(function ($characterCount, $paragraph) {
            return $characterCount + strlen($paragraph);
        });

        return number_format($totalCharacters / $this->paragraphs->count(), 2);
    }

    public function averageWordsPerParagraph()
    {
        $totalWords = $this->paragraphs->flatMap(function ($paragraph) {
            $words = collect(preg_split("/\W/", $paragraph))
                ->filter(function ($word) {
                    return empty(!$word);
                })->values();

            return $words;
        });

        return number_format($totalWords->count() / $this->paragraphs->count(), 2);
    }

    public function averageSentencesPerParagraph()
    {
        $totalSentences = $this->paragraphs->flatMap(function ($paragraph) {
            $sentences = collect(preg_split("/[.!?]+[\s]/", $paragraph))
                ->filter(function ($sentence) {
                    return empty(!$sentence);
                })->values();

            return $sentences;
        });

        return number_format($totalSentences->count() / $this->paragraphs->count(), 2);
    }

    public function shortestParagraph()
    {
        //This will only return one paragraph. What to do in case of tie?
        $shortestParagraph = $this->paragraphs->reduce(function ($shortestParagraph, $currentParagraph) {
            if($shortestParagraph == null) {
                return $currentParagraph;
            }

            if (strlen($currentParagraph) <= strlen($shortestParagraph)) {
                return $currentParagraph;
            }

            return $shortestParagraph;
        });

        return [
            'paragraph' => $shortestParagraph,
            'length' => strlen($shortestParagraph)
        ];
    }

    public function longestParagraph()
    {
        //This will only return one paragraph. What to do in case of tie?
        $longestParagraph = $this->paragraphs->reduce(function ($longestParagraph, $currentParagraph) {
            if($longestParagraph == null) {
                return $currentParagraph;
            }

            if (strlen($currentParagraph) >= strlen($longestParagraph)) {
                return $currentParagraph;
            }

            return $longestParagraph;
        });

        return [
            'paragraph' => $longestParagraph,
            'length' => strlen($longestParagraph)
        ];
    }
}
