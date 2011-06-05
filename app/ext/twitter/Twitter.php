<?php
defined('BASE') or exit('Direct script access is not allowed!');

class Twitter extends BaseController
{	
	public function view()
	{		
		$v = $this->smarty;
		$v->setTemplateDir(BASEEXT.'/twitter/view');

        $v->assign('twitterUsername', $this->params[0]);
        $this->display($v, 'twitter.html');
	}
}
