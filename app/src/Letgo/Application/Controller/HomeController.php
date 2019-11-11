<?php

namespace App\Letgo\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class HomeController extends AbstractController
{
	public function index()
	{
		return new Response(<<<EOT
			<!doctype html>
			<html>
			<body>
			<h1>Welcome to the Shout API!</h1>

			<h2>Making tweets <i>LOUDER</i></h2>

			<a href = "/shout/realDonaldTrump?limit=2">View Live</a>

			<p><i>Example:</i></p>

			<pre>
			curl -s http://{$_SERVER['HTTP_HOST']}/shout/realDonaldTrump?limit=2
			[
				"BIG ANNOUNCEMENT WITH MY FRIEND AMBASSADOR NIKKI HALEY IN THE OVAL OFFICE AT 10:30AM!",
				"WILL BE GOING TO IOWA TONIGHT FOR RALLY, AND MORE! THE FARMERS (AND ALL) ARE VERY HAPPY WITH USMCA!"
			]
			</pre>
			<i><small>&copy; Copyright 2019 LetGo, Sean Morris</small></i>
			</body>
			</html>
			EOT
		);
	}
}
