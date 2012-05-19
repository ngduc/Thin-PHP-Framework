<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       app.model.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('Direct script access is not allowed!');

interface IBaseDao
{
	public function getAll($strWhere = '', $strOrderBy = '');

	public function countAll();

	public function getById($id);
	
	public function getByField($fieldName, $val);
    
    public function getFirstByField($fieldName, $val);
	
	public function removeById($id);
	
	public function remove($obj);
	
	public function removeByField($fieldName, $val);
	
	public function create($obj);
	
	public function update($obj, $arr);
	
	public function insertInto($commaSeparatedFieldNames, $paramArr);
}
