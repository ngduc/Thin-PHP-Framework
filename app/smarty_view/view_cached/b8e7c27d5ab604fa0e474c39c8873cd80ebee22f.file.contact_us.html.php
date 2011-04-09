<?php /* Smarty version Smarty-3.0.7, created on 2011-04-09 12:47:41
         compiled from "app/smarty_view/view\en_default/contact_us.html" */ ?>
<?php /*%%SmartyHeaderCode:63334da0b7ddccb6d3-95404981%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8e7c27d5ab604fa0e474c39c8873cd80ebee22f' => 
    array (
      0 => 'app/smarty_view/view\\en_default/contact_us.html',
      1 => 1301002914,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63334da0b7ddccb6d3-95404981',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_get_url')) include 'C:\Program Files (x86)\Zend\Apache2\htdocs\thinphp\lib\smarty\plugins\function.get_url.php';
?>				<h2>Contact Us</h2>
				<p>This demonstrates Form and server side Validation.</p>
<script type="text/javascript">
function validateContact() {	
	// make ajax call to validate() function in ContactUs Controller	
	$.ajax({
		type: 'post',
		url: '/contact-us/p/validate',		
		dataType: 'json', data: $('#cform').serialize(),
		success: function (rets) {			
			var countRets = TPF.countJSON(rets);			
			if (countRets > 0)
			{
				TPF.setFormError('#cform', '', ''); // clear errors
				for (var i = 0; i < countRets; i++) {
					var err = rets[i];
					if (err['field'] == 'recaptcha') {
						$('#recaptchaErr').html(err['msg']);
						Recaptcha.reload();
						continue;
					}
					TPF.setFormError('#cform', err['field'], err['msg']);
					if (i == 0) TPF.focusField('#cform', err['field']); // focus 1st error field
				}
			}
			else {
				TPF.delaySubmit('#cform', 300); // delay submit() to avoid flooding
				return true;
			}
		}
	});
	return false;
}
</script>
<form id="cform" name="cform" action="/contact-us" method="post" onsubmit="return validateContact()">
	<input name="ftoken" type="hidden" value="<?php echo $_smarty_tpl->getVariable('ftoken')->value;?>
">

<div id="contactForm">
	<span>Name</span>
	<input name="name" type="text" /><span class="fmsg"></span>
	<span>Email</span>
	<input name="email" type="text" /><span class="fmsg"></span>
	<span>Opt-in Mailing list <input name="optin" class="fcheckbox" type="checkbox"></span>
	
	<span>Message</span>
	<textarea name="msg"></textarea><span class="fmsg"></span>

		<span>reCAPTCHA extension:</span>
		<?php echo smarty_function_get_url(array('url'=>"/recaptcha"),$_smarty_tpl);?>
<span class="fmsg" id="recaptchaErr"></span>

	<input id="contactSubmit" name="contactSubmit" type="submit" value="Submit"><span></span>	
</div>
</form>
<script type="text/javascript">
	TPF.focusField('#cform', 'name');
</script>