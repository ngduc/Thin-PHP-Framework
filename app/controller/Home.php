<?php

class Home extends BaseController
{
	public function view()
	{
        $v = $this->smarty;
        $v->assign('title', t('home_page_title'));

        $v->assign('inc_content', v('welcome.html'));
        $v->assign('text_today', t('today_is', date('d/m/Y')));
        
        $this->display($v, v('index.html'));
	}
}
?>
