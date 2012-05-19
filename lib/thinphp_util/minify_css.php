<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       lib.thinphp_util
 * @license       TPF License http://bit.ly/TPFLicense
 */
define('BASE', dirname(__FILE__).'/../..');

$listFilename = $_GET['list'];

ob_start("ob_gzhandler"); // second: gzip
ob_start("minify"); // first: minify
function minify($buffer) {
	// remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	// remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer;
}
// read CSS, replace relative paths (like url(relpath...)) with absolute paths - ref: #minifycss_absPathCSS
function absPathCSS($cssFile, $prefixPath) {	
	$prefixPath = substr ($cssFile, 0, strrpos($cssFile, '/')+1);

	$css = file_get_contents(BASE . $cssFile);	
	
	$pattern = '/url\(([\'"]?)(.*)([\'"])\)/i'; // replace url('...') or url("...") first
	$replacement = 'url(${1}'.$prefixPath.'${2}${3})';
	$css = preg_replace($pattern, $replacement, $css);
	
	$pattern = '/url\(([^\'"\/])(.*)\)/i'; // replace url(...)
	$replacement = 'url('.$prefixPath.'${1}${2})';
	$css = preg_replace($pattern, $replacement, $css);

	// replace back: http..., https..., /... to keep them like before.
	$css = str_replace($prefixPath.'https://', 'https://', $css);
	$css = str_replace($prefixPath.'http://', 'http://', $css);
	$css = str_replace($prefixPath.'/', '/', $css);
	
	echo $css;	
}

header ("content-type: text/css; charset: UTF-8");
header ("cache-control: must-revalidate");
$offset = 3600 * 24 * 7; // 7 days
$expire = "Expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT"; 
header ($expire);

// read listfile & include each file in there.
if ($arr = @file($listFilename)) {
	foreach ($arr as $line) {
		if (strlen($line) > 3) {			
			include absPathCSS( trim($line) );
		}
	}
}	
ob_end_flush();
ob_end_flush();
