<?php

function isFlooding($lastRequestTime)
{
	global $app_i;
	if ($lastRequestTime != false && $lastRequestTime > microtime(true) - $app_i['flood_limit']) return true;
	return false;
}

function genFormToken()
{
	global $app_i;
	return md5(uniqid(rand()).$app_i['md5salt']); 
}

/**
 * Generate random unique id
 * Example: genUid(8);
 * @author gord - http://j.mp/4NmRr
 */
function genUid($len, $charset='a-z0-9')
{
	global $app_i;
    $hex = md5($app_i['md5salt'] . uniqid('', true));
    $pack = pack('H*', $hex);
    $uid = base64_encode($pack);	// max 22 chars

    $uid = preg_replace("/[^$charset]/", "", $uid);    // mixed case
    //$uid = preg_replace("[^A-Za-z0-9]", "", $uid);    // mixed case
    //$uid = preg_replace("[^A-Z0-9]", "", strtoupper($uid));    // uppercase only
    
    if ($len < 3) $len = 3;
    if ($len > 128) $len = 128;			// prevent silliness, can remove
    while (strlen($uid) < $len) {
        $uid = $uid . gen_uuid(22);		// append until length achieved
    }
    return substr($uid, 0, $len);
}
