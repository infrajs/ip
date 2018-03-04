<?php
namespace infrajs\ip;
use akiyatkin\boo\MemCache;
use infrajs\load\Load;
use infrajs\lang\Lang;

class IP {
	public static $conf = array();
	public static function get ($ip = false, $lang = 'en')
	{
		if (!$ip) $ip = $_SERVER['REMOTE_ADDR'];
		if ($ip === true) $ip = '';
		//echo '<pre>';
		//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		//exit;
		$data = MemCache::exec('Регион ip адресов', function ($ip) {
			$src = 'http://freegeoip.net/json/'.$ip;
			$data = file_get_contents($src);
			$data = json_decode($data, true); 
			if (empty($data)) return $data;
			$data['time'] = time();
			return $data;
		}, array($ip), ['akiyatkin\boo\Cache','getDurationTime'], ['last month']);


		foreach(array('country_name','region_name','city','country_name') as $k) {
			if (!empty($data[$k])) $data[$k] = Lang::lang($lang, 'ip', $data[$k]);
		}
		$data['lang'] = $lang;
		return $data;
	}
}