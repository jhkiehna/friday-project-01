<?php

namespace App\Document;

use App\Document\Sentence;

class Paragraph
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
        return $this->paragraphs();
    }

    public function paragraphs()
    {
        $paragraphs = collect(explode("\n\n", $this->content))
            ->filter(function ($paragraph) {
                return empty(!$paragraph);
            })
            ->values();

        
        if ($this->number != null) {
            return $paragraphs->get($this->number - 1);
        }

        return $paragraphs;
    }

    public function sentence($number = null)
    {
        $sentence = new Sentence($this->paragraphs($this->number), $number);

        return $sentence;
    }
}
