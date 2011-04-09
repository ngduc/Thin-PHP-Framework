<?php

class Article extends BaseController
{
	public function view()
	{		
		$articleId = $this->params[0];

		$v = $this->smarty;
		$v->assign('title', 'My Articles');
		$v->assign('inc_content', v('article_'.$articleId.'.html'));
		
		$this->display($v, v('index.html'));
	}
}
?>