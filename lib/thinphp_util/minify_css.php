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
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	// remove tabs, spaces, newlines, etc.
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer;
}
// read CSS, replace relative paths (like url(relpath...)) with absolute paths - see: #minifycss_absPathCSS
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
$offset = 60 * 60 * 24 * 7; // 7 days
$expire = "Expires: " . gmdate ("D, d M Y H:i:s", time() + $offset) . " GMT"; 
header ($expire);

// your CSS files
absPathCSS('/web/js/jquery/colorbox/colorbox.css');
absPathCSS('/web/js/jquery/fancybox/jquery.fancybox-1.3.4.css');
absPathCSS('/web/css/style.css');
absPathCSS('/web/css/style_ext.css');
	
ob_end_flush();
ob_end_flush();
