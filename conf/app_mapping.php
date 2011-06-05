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

	// Custom URI Mapping - start with a '/' & no ending '/'
	// 		URI => controllerPath (relative from /app/), controllerName, [parameters]
	// 		Example:
	// http://thinphp.local:8010/products/our-products => map to: thinphp/app/controller/products/OurProducts.php
	
	$arr_mapping = array(
		'/products/our-products' => array('controller/products', 'OurProducts'),
		
		// Mapping example with Parameters:
		'/terms' => array('controller', 'Display', array('terms.html', 'Terms and Conditions'))
	);	
