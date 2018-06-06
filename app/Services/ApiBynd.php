<?php

namespace App\Services;

use GuzzleHttp\Client;

class ApiBynd
{
	function __construct()
	{
	}
	
	/**
     * Get all trips from specified date
     *
     * @param $date
     * @return array
     */
	static function accessDate($date)
	{
		$client = new Client();
		$res = $client->request('GET', env('bynd_api_address').$date,[
			'auth' => [env('bynd_api_login'), env('bynd_api_password')]
		]);
		return json_decode($res->getBody(), true)['data'];
	}
}