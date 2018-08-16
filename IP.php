<?php
namespace infrajs\ip;
use akiyatkin\boo\MemCache;
use infrajs\load\Load;
use infrajs\lang\Lang;
use infrajs\config\Config;

class IP {
	public static $conf = array();
	public static function lang($str = null) {
		if (is_null($str)) return Lang::name('ip');
		return Lang::str('ip', $str);
	}
	public static function get ($ip = false, $lang = 'en')
	{
		if (!$ip) $ip = $_SERVER['REMOTE_ADDR'];
		if ($ip === true) $ip = '';
		//echo '<pre>';
		//debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		//exit;
		$conf = Config::get('ip');
		$data = MemCache::exec('Регионы ip адресов', function ($ip, $key) {
			if (!empty($key)) {
				//$ip = '62.106.100.30';
				$src = 'http://api.ipstack.com/'.$ip.'?access_key='.$key.'&output=json&language=en';
				//$src = 'http://freegeoip.net/json/'.$ip;

				$data = file_get_contents($src);
				$data = json_decode($data, true); 
			} else {
				error_log('infrajs/ip: Требуется ключ ipstack.com');
				$data = array();
			}
			if (empty($data)) return $data;
			$data['time'] = time();
			return $data;
		}, array($ip,$conf['key']), ['akiyatkin\boo\Cache','getDurationTime'], ['last month']);

		foreach (array('country_name','region_name','city','country_name') as $k) {
			if (!empty($data[$k])) $data[$k] = Lang::lang($lang, 'ip', $data[$k]);
			else $data[$k] = '';
		}

		$data['lang'] = $lang;
		return $data;
	}
}