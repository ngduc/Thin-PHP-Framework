<?php

function validate_username($s)
{
	if (!isset($s) || trim($s)=='') return false;
	if (preg_match("/^[0-9a-zA-Z_]{3,}$/", $s) === 0) return false;
	return true;
}
?>