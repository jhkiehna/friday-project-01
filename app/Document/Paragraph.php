<?php

namespace App\Document;

use App\Document\Content;

class Paragraph
{
    protected $paragraphs;

    public function __construct(Content $text)
    {
        $this->paragraphs = $this->setParagraphs($text->getContent());
    }

    private function setParagraphs($text)
    {
        return collect(explode("\n", $text))
            ->filter(function ($paragraph) {
                return empty(!$paragraph);
            })
            ->values();
    }

    public function getParagraph($number)
    {
        return $this->paragraphs->get($number);
    }

    /**
     * Undocumented function
     *
     * If it receives two paramaters, it takes paragraps at index $x to $y
     * if it receives on paramaters, it takes the first $x paragraphs
     * If it receives no paramaters, it returns all paragraphs
     * 
     * @param [type] $startOrNumber
     * @param [type] $end
     * @return Collection
     */
    public function getParagraphs($startOrNumber = null, $end = null)
    {
        if (!empty($startOrNumber) && !empty($end)) {
            return $this->paragraphs->slice($startOrNumber, $end);
        }

        if (!empty($startOrNumber)) {
            return $this->paragraphs->take($startOrNumber);
        }

        return $this->paragraphs;
    }
}
