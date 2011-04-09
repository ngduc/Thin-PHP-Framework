<?php

class Display extends BaseController
{
	public function view()
	{
		if ( !isset($this->params[0])) die('Invalid parameters!');
		
		$incView = $this->params[0];
		if (isset($this->params[1])) $pageTitle = $this->params[1];
		
		$v = $this->smarty;
		$v->assign('title', $pageTitle);
		$v->assign('inc_content', v($incView));

		$this->display($v, v('index.html'));
	}
}
?>
