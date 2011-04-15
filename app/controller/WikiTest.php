<?php
include BASEEXT.'/wiki2html/Wiki2html.php';
include BASEEXT.'/syntaxhighlighter/SyntaxHighlighter.php';

class WikiTest extends BaseController
{
	public function view()
	{
		$s = file_get_contents(BASEVIEW.'/'.v('wiki_test.html'));
		
		$s = Wiki2html::process($s);
		$s = SyntaxHighlighter::process($s);
		
        $v = $this->smarty;
        $v->assign('inc_content', v('wiki_test_footer.html'));
        $v->assign('content', $s);
        $this->display($v, v('index.html'));
	}
}
?>
