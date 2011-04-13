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

require_once BASE.'/app/model/UserDAO.php';

/**
 * DAOFactory (shortname: DAOs). Update all your DAO classes here.
 */
abstract class DAOs
{
	// Singleton pattern. We only create one instance per DAO.
	private static $_DAOs;
	
	private static $_userDAO;
	
	/**
	 * @return UserDAO
	 */
	public static function getUserDAO()
	{
		if ( !isset(self::$_userDAO) )
		{
			self::$_userDAO = new UserDAO();
			return self::$_userDAO;
		}
		return self::$_userDAO;
	}
	
	public static function getDAO($daoClass)
	{
		if ( !isset(self::$_DAOs["$daoClass"]) )
		{
			$daoPath = BASE."/app/model/$daoClass.php";			
			if (file_exists($daoPath)) {				
				require_once BASE."/app/model/$daoClass.php";
				self::$_DAOs["$daoClass"] = new $daoClass();				
				return self::$_DAOs["$daoClass"];
			} else {
				return null;
			}
		}
		return self::$_DAOs["$daoClass"];
	}
}
?>