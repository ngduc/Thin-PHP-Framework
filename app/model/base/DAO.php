<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.model.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('Direct script access is not allowed!');

/**
 * DAOFactory (shortname: DAO). Update all your DAO classes here.
 */
abstract class DAO
{
	// Singleton pattern. We only create one instance per DAO.
	private static $_DAO;
	
	/**
	 * Get a DAO handler.
	 * Example: $dao = getDAO('UserDAO');
	 * Example: $dao = getDAO('admin/LogDAO');
	 * @return DAO handler
	 */
	public static function getDAO($dao)
	{
        $className = $dao;
        $p = strpos($dao, '/');
        if ($p !== false) $className = substr($dao, $p+1); // get filename (classname) only.

		if ( !isset(self::$_DAO[ $className ]) )
		{
			$daoPath = BASE."/app/model/$dao.php";
			if (file_exists($daoPath)) {
				require_once BASE."/app/model/$dao.php";
                
				self::$_DAO[ $className ] = new $className();
				return self::$_DAO[ $className ];
			} else {
				return null;
			}
		}
		return self::$_DAO[ $className ];
	}
}
