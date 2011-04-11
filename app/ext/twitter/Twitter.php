<?php
defined('BASE') or exit('Direct script access is not allowed!');

class Twitter extends BaseController
{	
	public function view()
	{
		$html = file_get_contents(BASEEXT.'/twitter/twitter.html');
		echo $html;
	}
}
?>