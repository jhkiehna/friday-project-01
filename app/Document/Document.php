<?php

namespace App\Document;

use App\Document\Paragraph;

class Document
{
    public $content;

    public function __construct($filePath)
    {
        $this->content = file_get_contents($filePath);
    }

    public function paragraph($number = null){
        $paragraph = new Paragraph($this->content, $number);

        return $paragraph;
    }
}
