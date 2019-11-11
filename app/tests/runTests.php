<?php
require __DIR__ . '/../vendor/autoload.php';

$tests = [
	\App\Tests\ShoutTest::class
];

foreach($tests as $testClass)
{
	$test = new $testClass;
	$test->run(new \TextReporter());
		echo PHP_EOL;
}
