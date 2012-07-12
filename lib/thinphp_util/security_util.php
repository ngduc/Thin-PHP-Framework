<?php

function isFlooding($lastRequestTime)
{
	global $app_i;
	if ($lastRequestTime != false && $lastRequestTime > microtime(true) - $app_i['flood_limit']) return true;
	return false;
}

function genFormToken($tokenName = ''){
	global $app_i;
    startSession();
	$token = md5(uniqid(rand()).$app_i['md5salt']);
    if (strlen($tokenName) > 0) $_SESSION[$tokenName] = $token;
    return $token;
}
function checkFormToken($tokenName, $formTokenValue){
    startSession();
    if ($formTokenValue != $_SESSION[$tokenName]){
        exit('ERROR: invalid form token! Do not submit your form twice.');
    }
    unset($_SESSION[$tokenName]);
}

/**
 * Generate random unique id. Minimum length: 3
 * Example: genUid(8);
 * @author gord - http://j.mp/4NmRr
 */
function genUid($len, $charset='0-9a-zA-Z')
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
        $uid = $uid . genUid(22);		// append until length achieved
    }
    return substr($uid, 0, $len);
}
