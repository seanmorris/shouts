<?php

namespace App\Letgo\Application\Controller;

use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Letgo\Domain\Shout;

final class ShoutController extends AbstractController
{
	const MAX_TWEETS = 10;

	public function index(TweetRepositoryInMemory $repo, Request $request, $twitterName)
	{
		$limit = (int) $request->get('limit');

		if($limit > static::MAX_TWEETS)
		{
			return JsonResponse::create(['Error' => sprintf(
				'Cannot load more than %s tweets.',
				static::MAX_TWEETS
			)]);
		}

		$tweets = $repo->searchByUserName($twitterName, $limit);

		$shouts = array_map(
			function($tweet) { return (string) new Shout($tweet); },
			$tweets
		);

		return JsonResponse::create($shouts);
	}
}
