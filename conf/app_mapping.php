<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       app.conf
 * @license       TPF License http://bit.ly/TPFLicense
 */

	// Note: URI is automatically mapped to the Controller with the same name. (/news => News.php)
	// Mapping is only needed when you want to map an URI to a different Controller.
	
	// Custom URI Mapping - start with a '/' & no ending '/'
	// 		URI => controllerPath (relative from /app/), controllerName, [parameters]
	// 		Example:
	// http://thinphp.local:8010/products/our-products => map to: thinphp/app/controller/products/OurProducts.php
	
	$arr_mapping = array(
		'/products/our-products' => array('controller/products', 'OurProducts'),
		
		// Mapping example with Parameters:
		'/terms' => array('controller', 'Display', array('terms.html', 'Terms and Conditions'))
	);	
