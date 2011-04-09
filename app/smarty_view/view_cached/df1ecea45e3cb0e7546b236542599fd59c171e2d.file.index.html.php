<?php /* Smarty version Smarty-3.0.7, created on 2011-04-09 12:47:36
         compiled from "app/smarty_view/view\en_default/index.html" */ ?>
<?php /*%%SmartyHeaderCode:215114da0b7d80e8f58-97780200%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df1ecea45e3cb0e7546b236542599fd59c171e2d' => 
    array (
      0 => 'app/smarty_view/view\\en_default/index.html',
      1 => 1302153036,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '215114da0b7d80e8f58-97780200',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_get_url')) include 'C:\Program Files (x86)\Zend\Apache2\htdocs\thinphp\lib\smarty\plugins\function.get_url.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $_smarty_tpl->getVariable('title')->value;?>
</title>
	<meta name="keywords" content="php,framework,thin,slim,small,light,fast,easy" />
	<meta name="description" content="ThinPHP is a lightweight, flexible PHP5 MVC framework. It is fast, simple and highly extensible framework." />
	<link rel="Shortcut Icon" href="data:image/gif;base64,R0lGODlhEAAQALMAAPwCNPz+/ACe/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAQABAAAwQsMMhJqwQ4AM03v+AmipOHkWMZdqDlvvB1zvQZ37j9jd7umzKTTfdpkXDIWAQAOw==" type="image/gif" />

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js" type="text/javascript"></script>

	<script src="/lib/thinphp_util/minify_js.php?v=1005" type="text/javascript"></script>
	<link href="/lib/thinphp_util/minify_css.php?v=1005" rel="stylesheet" type="text/css" media="all" />
	<!-- Use below & comment above if you don't want to minify, compress & cache js,css...
			<script src="/web/js/jquery/jquery.cookie.min.js" type="text/javascript"></script>
			<script src="/js/thinphp.js" type="text/javascript"></script>
			<link href="/css/style.css" rel="stylesheet" type="text/css" />
			<link href="/css/style_ext.css" rel="stylesheet" type="text/css" />-->
</head>
<body>

<div id="outer">
	<div id="header">
		<h1><a href="/home">Thin PHP</a></h1>
		<h2>Framework</h2>
	</div>
	<div id="menu">
		<ul>
			<li class="first"><a href="/home" accesskey="1" title="">Home</a></li>
			<li><a href="/products/our-products" accesskey="1" title="">Products</a></li>
			<li><a href="/about-us" accesskey="2" title="">About Us</a></li>
			<li><a href="/editable-page" accesskey="2" title="">Editable Page</a></li>
			<li><a href="/contact-us" accesskey="5" title="">Contact Us</a></li>
		</ul>
	</div>
	<div id="content">
		<div id="primaryContentContainer">
			<div id="primaryContent">
				<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('inc_content')->value), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
			</div>
		</div>
		<div id="secondaryContent">
			<p>
			<a href="#" onclick="$.cookie('cke_view', '', { path: '/', expires: 7 }); location.reload(true)"><?php echo $_smarty_tpl->getVariable('lang')->value['english_n'];?>
</a> -
			<a href="#" onclick="$.cookie('cke_view', 'ja_jp', { path: '/', expires: 7 }); location.reload(true)"><?php echo $_smarty_tpl->getVariable('lang')->value['japanese_n'];?>
</a>
			<p/>
			<h3>Sign in</h3>
			<p>
				<?php if (empty($_smarty_tpl->getVariable('hide_signin',null,true,false)->value)){?>
					<?php echo smarty_function_get_url(array('url'=>"/sign-in"),$_smarty_tpl);?>

				<?php }?>
			</p>
			
			<a href="http://secure.hostgator.com/~affiliat/cgi-bin/affiliates/clickthru.cgi?id=ngduc-"><img src="http://tracking.hostgator.com/img/Shared/234x60.gif" width="220" border=0></a>
            <br/>
            <a href="http://www.ultrawebsitehosting.com/3694-0-1-44.html" target="_blank"><img border="0" src="http://affiliates.ultrawebsitehosting.com/banners/ultra-234x60-1.gif" width="220" height="60" alt=""></a>
			
			<p>
				<?php echo smarty_function_get_url(array('url'=>"/twitter"),$_smarty_tpl);?>

			</p>
						
			<h3>Nunc pellentesque</h3>
			<p>Sed vestibulum blandit nisl. Quisque elementum convallis purus. Suspendisse potenti. Donec nulla est, laoreet quis, pellentesque in. <a href="#">More&#8230;</a></p>
			<h3>Ipsum Dolorem</h3>
			<ul>
				<li><a href="#">Sagittis Bibendum Erat</a></li>
				<li><a href="#">Malesuada Turpis</a></li>
				<li><a href="#">Quis Gravida Massa</a></li>
				<li><a href="#">Inerat Viverra Ornare</a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<div id="footer">
		<p>Powered by <a href="http://www.thinphp.com">Thin PHP Framework</a><br/><a href="/terms">Terms and Conditions</a></p>
	</div>
</div>
	<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('inc_tracking_code')->value), $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
</body>
</html>
