<?php

class OurProducts extends BaseController
{
	public function view()
	{
		$v = $this->smarty;
		$v->assign('title', t('product_page_title'));
		$v->assign('inc_content', v('products/our_products.html'));
		
		$this->display($v, v('index.html'));
	}
}
