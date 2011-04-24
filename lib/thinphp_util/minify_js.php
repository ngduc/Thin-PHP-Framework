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
 
ob_start("ob_gzhandler"); // second: gzip
ob_start("minify"); // first: minify
function minify($buffer) {
	// remove comments
	$buffer = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $buffer);
	// remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer;
}

header ("content-type: text/css; charset: UTF-8");
header ("cache-control: must-revalidate");
$offset = 60 * 60 * 24 * 7; // 7 days
$expire = "Expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT"; 
header ($expire);

/* your css files */
include BASE.'/web/js/jquery/colorbox/jquery.colorbox-min.js';
include BASE.'/web/js/jquery/jquery.cookie.min.js';
include BASE.'/web/js/thinphp/thinphp.js';

ob_end_flush();
ob_end_flush();
