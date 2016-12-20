<?php
namespace infrajs\ip;
use infrajs\cache\Cache;
use infrajs\load\Load;
use infrajs\lang\Lang;

class IP {
	public static $conf = array();
	public static function get ($ip = false, $lang = 'en')
	{
		if (!$ip) $ip = $_SERVER['REMOTE_ADDR'];
		if ($ip === true) $ip = '';
		

		$data = Cache::exec(array(date('m.Y')),__FILE__, function ($ip) {
			$src = 'http://freegeoip.net/json/'.$ip;
			$data = file_get_contents($src);
			$data = json_decode($data, true);
			if (empty($data)) return $data;
			return $data;
		}, array($ip), isset($_GET['re']));


		foreach(array('country_name','region_name','city','country_name') as $k) {
			if (!empty($data[$k])) $data[$k] = Lang::lang($lang, 'ip', $data[$k]);
		}
		$data['lang'] = $lang;
		return $data;
	}
}