<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       lib.thinphp_util
 * @license       TPF License http://bit.ly/TPFLicense
 */
define('BASE', dirname(__FILE__).'/../..');

$listFilename = $_GET['list'];

ob_start("ob_gzhandler"); // second: gzip
ob_start("minify"); // first: minify
function minify($buffer) {
	// remove comments
	$buffer = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $buffer);
	// remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer;
}

$offset = 3600 * 24 * 7; // 7 days
header ("content-type: text/javascript; charset: UTF-8");
header ("cache-control: must-revalidate");
$expire = "Expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT";
header ($expire);

// read listfile & include each file in there.
if ($arr = @file($listFilename)) {
	foreach ($arr as $line) {
		if (strlen($line) > 3) {			
			include BASE.trim($line);			
		}
	}
}
ob_end_flush();
ob_end_flush();
