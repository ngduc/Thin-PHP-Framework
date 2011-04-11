<?php
defined('BASE') or exit('Direct script access is not allowed!');

class SyntaxHighlighter
{	
	public static function process($str)
	{
		$inc = file_get_contents(BASEEXT.'/syntaxhighlighter/inc_view.html');
		
		$ret = $str.$inc;
		return $ret;
	}
}
?>