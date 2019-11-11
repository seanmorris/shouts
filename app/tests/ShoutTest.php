<?php
namespace App\Tests;

use App\Letgo\Domain\Tweet;
use App\Letgo\Domain\Shout;

class ShoutTest extends \UnitTestCase
{
	public function TestPlainText()
	{
		$expectations = [
			'Plain tweet'     => 'PLAIN TWEET!',
			'Something else'  => 'SOMETHING ELSE!',
			'Yet another one' => 'YET ANOTHER ONE!',
		];

		foreach($expectations as $input => $expectedOutput)
		{
			$tweet = new Tweet($input);
			$shout = (string) new Shout($tweet);

			$this->assertEqual((string) $shout, $expectedOutput);
		}
	}
	public function TestEmojiSuffix()
	{
		$expectations = [
			'"Be yourself; everyone else is already taken."' => '"BE YOURSELF; EVERYONE ELSE IS ALREADY TAKEN!"',
			'"So many books, so little time."' => '"SO MANY BOOKS, SO LITTLE TIME!"',
			'"A room without books is like a body without a soul."' => '"A ROOM WITHOUT BOOKS IS LIKE A BODY WITHOUT A SOUL!"'
		];

		foreach($expectations as $input => $expectedOutput)
		{
			$tweet = new Tweet($input);
			$shout = (string) new Shout($tweet);

			$this->assertEqual((string) $shout, $expectedOutput);
		}
	}

	public function TestQuotedTweets()
	{
		$expectations = [
			'Gettin some chicken 🍗🍗🍗' => 'GETTIN SOME CHICKEN! 🍗🍗🍗',
			'So hot today. 🌡️🌡️🌡️' => 'SO HOT TODAY! 🌡️🌡️🌡️',
			'Honk honk. 🤡🌎'  => 'HONK HONK! 🤡🌎',
		];

		foreach($expectations as $input => $expectedOutput)
		{
			$tweet = new Tweet($input);
			$shout = (string) new Shout($tweet);

			$this->assertEqual((string) $shout, $expectedOutput);
		}
	}
}
