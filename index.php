<?php

use infrajs\rest\Rest;
use infrajs\access\Access;
use infrajs\ip\IP;
use infrajs\ans\Ans;

Access::test(true);

return Rest::get( function () {
	echo 'Пример теста <a href="/-ip/85.114.185.182">85.114.185.182</a>';	
}, function($ip){
	$res = IP::get($ip,'en');
	return Ans::ans($res);
});