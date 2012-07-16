<?php

class Home extends BaseController
{
	public function view()
	{
		$strTime = date('d/m/Y H:i:s');
		
		$v = $this->smarty;
		$v->assign('title', t('home_page_title'));
		$v->assign('inc_content', v('welcome.html'));
		$v->assign('text_today', t('today_is', $strTime));
		
		$this->display($v, v('index.html'));
		
		/* --------- non-Smarty way: (see barebone TPF version)
		$strTime = date('d/m/Y H:i:s');
		$v = $this->processTemplate(v('index.html'),
						array('<!--CONTENT-->' => v('welcome.html')),
						array('time' => $strTime)	// include vars
		);
		$this->display($v);
		*/
	}
}