<?php

class Jackets extends BaseController
{
	public function view()
	{
		$v = $this->smarty;

		$v->assign('title', 'Our Products');		
		$v->assign('inc_content', v('products/jackets.html'));
		
		$this->display($v, v('index.html'));
	}
}
