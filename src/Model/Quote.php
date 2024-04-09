<?php

namespace App\Model;

final readonly class Quote
{
    private string $author;

    private string $quote;

    public function __construct(string $quote, string $author)
    {
        $this->quote = $quote;
        $this->author = $author;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getQuote(): string
    {
        return $this->quote;
    }
}