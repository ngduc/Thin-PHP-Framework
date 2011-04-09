<?php

class EditablePage extends BaseController
{
	public function view()
	{	
		$v = $this->smarty;
		$v->assign('title', 'About Us');
		$v->assign('inc_content', v('editable_page.html'));
		
		$this->display($v, v('index.html'));
	}
}
?>