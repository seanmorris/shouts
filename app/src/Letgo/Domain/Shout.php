<?php

namespace App\Letgo\Domain;

use App\Letgo\Domain\Tweet;

final class Shout
{
    private $text;

    public function __construct(Tweet $tweet)
    {
        $this->tweet = $tweet;
    }

    public function getText(): string
    {
        $text = $this->tweet->getText();
        $text = preg_replace('/[\.\!\?,](\W+)?$/', '$1', $text);
        $text = preg_replace('/(\w)(\W+)?$/', '$1!$2', $text);
        $text = strtoupper($text);

        return $text;
    }

    public function __toString(): string
    {
    	return $this->getText();
    }
}
