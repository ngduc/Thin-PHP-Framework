<?php

class AboutUs extends BaseController
{
	public function view()
	{	
		$v = $this->smarty;
		$v->assign('title', 'About Us');
		$v->assign('inc_content', v('about_us.html'));
		
		$this->display($v, v('index.html'));
	}
}
?>