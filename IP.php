<?php
namespace infrajs\ip;
use infrajs\cache\Cache;
use infrajs\load\Load;

class IP {
	public static $conf = array();
	public static function get ($ip = false)
	{
		if (!$ip) $ip = $_SERVER['REMOTE_ADDR'];
		if ($ip === true) $ip = '';
		return Cache::exec(array(date('m.Y')),__FILE__, function ($ip) {
			$src = 'http://freegeoip.net/json/'.$ip;
			$data = file_get_contents($src);
			$data = json_decode($data, true);
			return $data;
		}, array($ip), isset($_GET['re']));
	}
}