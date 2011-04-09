<?php /* Smarty version Smarty-3.0.7, created on 2011-04-09 12:47:36
         compiled from "app/smarty_view/view\en_default/signin/signin_form.html" */ ?>
<?php /*%%SmartyHeaderCode:179244da0b7d8358e40-67310610%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06265964f7424ef4c319fbc7dbc96ce133eb893f' => 
    array (
      0 => 'app/smarty_view/view\\en_default/signin/signin_form.html',
      1 => 1302155664,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '179244da0b7d8358e40-67310610',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript">
function validateSignin() {	
	// make ajax call to validate() function in Signin Controller	
	$.ajax({
		type: 'post',
		url: '/sign-in/p/validate',
		dataType: 'json', data: $('#signinForm').serialize(),
		success: function (rets) {
			var countRets = TPF.countJSON(rets);
			TPF.setFormError('#signinForm', '', ''); // clear errors
			if (countRets > 0)
			{
				TPF.setFormError('#signinForm', rets[0]['field'], rets[0]['msg']);
				TPF.focusField('#signinForm', rets[0]['field']);	
			} else {
				TPF.delaySubmit('#signinForm', 300);	// delay submit() to avoid flooding
				return true;
			}
		}
	});
	return false;
}
</script>
<form id="signinForm" action="/sign-in" method="post" onsubmit="return validateSignin()">
	<a href="http://demo.thinphp.com/app/ext/authentication/oauth/oauth_google.php?refresh" class="signin_google"><img border="0" src="/web/img/oauth/google_32.png" /></a>
	<a href="http://demo.thinphp.com/app/ext/authentication/oauth/oauth_facebook.php?refresh" class="signin_facebook"><img border="0" src="/web/img/oauth/facebook_32.png" /></a>
	<a href="http://demo.thinphp.com/app/ext/authentication/oauth/oauth_twitter.php?refresh" class="signin_twitter"><img border="0" src="/web/img/oauth/twitter_32.png" /></a>
	
	<span>Username</span>
	<input name="username" type="text"><span class="fmsg"></span>
	<span>Password</span>
	<input name="password" type="password">

	<input id="signinSubmit" name="signinSubmit" type="submit" value="Sign in">
</form>
<script type="text/javascript">
	//$(".signin_google").colorbox({ width:"65%", height:"65%", iframe:true });	
</script>