<?php
defined('BASE') or exit('No direct script access allowed!');
require_once BASE.'/app/model/base/BaseBO.php';

/**
 * Auto generated Model Class represents table '${table_name}' 
 * @author: Thin PHP Framework
 * @date: ${date}
 */
class ${domain_class_name} extends BaseBO
{
	private $fields;
${variables}

	/**
	 * Default constructor
	 * @param value some value
	 */
	function __construct()
	{
		$args = func_get_args();
		if ( func_num_args() == 1 ) {
			$this->init( $args[0] );
		}
	}

	/**
	 * Initialize the business object with data read from the DB.
	 * @param row array containing one read record.
	 */
	private function init($fields)
	{
		$this->fields = $fields;
${init_variables}	
	}

	public function getFields() {
		return $this->fields;
	}

	${getset_methods}

	/**
	 * Return value of this object in a short string for debug.
	 */
	public function toStr()
	{
		${tostr_variables}
	}
}
?>