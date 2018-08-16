<?php
use infrajs\ip\IP;
use infrajs\ans\Ans;

$ans = array();

$data = IP::get(true);
if (!$data) return Ans::err($ans, 'Нет данных по IP сервера');

$data = IP::get();
if (!$data) return Ans::err($ans, 'Нет данных по IP клиента');


return Ans::ret($ans, 'Сделано несколько запросов, ответы получены');