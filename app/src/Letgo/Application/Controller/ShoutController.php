<?php

namespace App\Letgo\Application\Controller;

use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use App\Letgo\Infrastructure\Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Letgo\Domain\Shout;

final class ShoutController extends AbstractController
{
	const MAX_TWEETS   = 10;
	const CACHE_EXPIRY = 300;

	public function index(TweetRepositoryInMemory $repo, Cache $cache, Request $request, $twitterName)
	{
		$limit = (int) $request->get('limit');

		if($limit > static::MAX_TWEETS)
		{
			return JsonResponse::create(['Error' => sprintf(
				'Cannot load more than %s tweets.',
				static::MAX_TWEETS
			)]);
		}

		$key = sprintf('h-tweets;twitterName:%s', $twitterName);

		$tweets = [];

		if(!$tweets = $cache->load($key))
		{
			$tweets = $repo->searchByUserName($twitterName, static::MAX_TWEETS);

			$cache->store($key, $tweets, static::CACHE_EXPIRY);
		}

		$shouts = array_map(
			function($tweet) { return (string) new Shout($tweet); },
			$tweets
		);

		return JsonResponse::create(array_slice($shouts, 0 , $limit));
	}
}
