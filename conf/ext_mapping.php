<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.conf
 * @license       TPF License http://bit.ly/TPFLicense
 */

	$ext_mapping = array(
		//--- Authentication extension
			'/sign-in' => array('ext/authentication', 'SignIn'),
			'/sign-out' => array('ext/authentication', 'SignOut'),

		//--- Blog
			'/blog' => array('ext/blog', 'Blog'),
			'/blog-admin' => array('ext/blog', 'Blog', array('admin')),
			
		//--- Editor
			'/page-editor' => array('ext/editor', 'Editor'),

		//--- MathCaptcha extension
			'/mathcaptcha' => array('ext/mathcaptcha', 'MathCaptcha'),
				
		//--- ReCaptcha extension
			'/recaptcha' => array('ext/recaptcha', 'ReCaptcha'),
				
		// --- Twitter
			'/twitter' => array('ext/twitter', 'Twitter')
		//--- other extensions...
	);
?>