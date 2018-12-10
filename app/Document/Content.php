<?php

namespace App\Document;

class Content
{
    protected $textBody;

    public function __construct($textBody)
    {
        $this->textBody = $textBody;
    }

    public function getContent()
    {
        return $this->textBody;
    }
}
