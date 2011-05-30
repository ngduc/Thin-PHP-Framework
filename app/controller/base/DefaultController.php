<?php
defined('BASE') or exit('No direct script access allowed!');

class DefaultController extends BaseController
{	
	public function view()
	{
		echo 'DefaultController says: You entered an invalid URL! <p></p><a href="/">Back to homepage</a>';
	}
}