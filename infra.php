<?php
use infrajs\env\Env;
use infrajs\ip\IP;

Env::add('region', function () {
	$data = IP::get();
	$city = $data["region_code"];
	if ($city = "Tol'yatti") $city = "tolyatti";
	else if($city = "Samara") $city = "samara"

	return ;
}, function ($newval) {
	return in_array($newval, array('SAM','samara','syzran'));
});