<?php

function removeFirst($ch, $s)
{
    // remove the first character (if any). Example: '/dir/' => 'dir/'
    if (strlen($s) == 0) return $s;
    if ($s[0] == $ch) return substr($s, 1, strlen($s));
	return $s;
}

function removeLast($ch, $s)
{
	// remove the last character (if any). Example: '/dir/' => '/dir'
	$len = strlen($s);
	if ($len == 0) return $s;
	if ($s[$len-1] == $ch) return substr($s, 0, $len-1);
	return $s;
}

function removeFirstLast($ch, $s)
{
    $ret = removeFirst($ch, $s);
    $ret = removeLast($ch, $ret);
    return $ret;
}
