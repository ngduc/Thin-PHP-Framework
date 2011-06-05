<?php
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASEEXT.'/authentication/util.php';

class Editor extends BaseController
{
	public function processPost()
	{
		parent::processPost();

		copyItems($_POST, $fv, 'viewFile', 'jwEditor');
		
		$viewPath = BASEVIEW.'/'.currentViewDir().'/'.$fv['viewFile'];
		$newContent = html_entity_decode($fv['jwEditor'], ENT_QUOTES);
		if (file_exists($viewPath)) {
			$f = fopen ($viewPath, 'w');
			fwrite ($f, $newContent);
			fclose($f);
		}
		header('Location: '.$_SERVER['HTTP_REFERER']);		
	}

	public function view()
	{
		if ($this->isPosting()) return $this->processPost();
		
		session_start();		
		if (getLoggedInUsername() != '')
		{
			if (isset($this->params[0])) {
				$viewToEdit = $this->params[0];
				$viewPath = BASEVIEW.'/'.currentViewDir().'/'.$viewToEdit;
				if (file_exists($viewPath)) {					
					$viewContent = file_get_contents($viewPath);
					
					if (isDemoMode()) $viewContent .= "<p/><b>Demo Mode: This page is set to readonly in demo mode.</b>";
				}
				$html = file_get_contents_with_vars(BASEEXT.'/editor/page_editor.html', array(
							'{$viewFile}' => $viewToEdit,
							'{$viewContent}' => $viewContent));
				echo $html;
			}			
		} else {
			echo '';
		}
	}
}
