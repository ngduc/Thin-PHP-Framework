<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       app.web
 * @license       TPF License http://bit.ly/TPFLicense
 */

define('BASE', dirname(__FILE__));
require_once BASE.'/app/includes.php';
if ( !isset($_GET['route']) ) exit('No direct script access allowed!');

$c = new MainController( $_GET['route'] );
$c->handle(null);
