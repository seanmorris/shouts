<?php
namespace App\Letgo\Infrastructure;

class Cache
{
	protected $redis;

	public function __construct(string $redis_server, int $redis_port)
	{
		$this->redis = new \Redis();
		$this->redis->connect($redis_server, $redis_port);
	}

	public function store($key, $value, $expiry)
	{
		$this->redis->set($key, serialize($value));
		$this->redis->expire($key, $expiry);
	}

	public function load($key)
	{
		return unserialize($this->redis->get($key));
	}
}
