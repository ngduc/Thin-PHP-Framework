<?php

function is_flooding($lastRequestTime)
{
	global $app_i;
	if ($lastRequestTime != false && $lastRequestTime > microtime(true) - $app_i['flood_limit']) return true;
	return false;
}

function generateFormToken()
{
	global $app_i;
	return md5(uniqid(rand()).$app_i['md5salt']); 
}
