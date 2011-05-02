<?php

class TShirts extends BaseController
{
	public function view()
	{
		$v = $this->smarty;

		$v->assign('title', 'Our Products');		
		$v->assign('inc_content', v('products/t_shirts.html'));
		
		$this->display($v, v('index.html'));
	}
}
