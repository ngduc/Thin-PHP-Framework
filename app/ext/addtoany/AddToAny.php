<?php
defined('BASE') or exit('Direct script access is not allowed!');

class AddToAny extends BaseController
{
	public function view()
	{
		$title = $this->params[0];
		$curl = getCurrentUrl();
		$extPath = '/app/ext/addtoany';

		$html=<<<HTML
<!-- AddToAny BEGIN -->
<a class="a2a_dd" href="#"><img src="$extPath/img/share_save.png" width="171" height="16" border="0" alt="Share"/></a>
<script type="text/javascript">
function my_addtoany_onready() { // A custom "onReady" function for AddToAny
    a2a_config.target = '.a2a_dd';
    a2a.init('page');
}
var a2a_config = { // Setup AddToAny "onReady" callback
    tracking_callback: ["ready", my_addtoany_onready]
};
a2a_config.linkname = "$title";
a2a_config.linkurl = "$curl";
(function(){ // Load AddToAny script asynchronously
    var a = document.createElement('script');
    a.type = 'text/javascript';
    a.async = true;
    a.src = '$extPath/js/page.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(a, s);
})();
</script>
<!-- AddToAny END -->
HTML;
		echo $html;
	}
}
