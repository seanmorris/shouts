<?php

namespace App\Letgo\Domain;

interface TweetRepository
{
    public function searchByUserName(string $username, int $limit): array;
}
