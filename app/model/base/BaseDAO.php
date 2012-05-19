<?php
/**
 * Thin PHP Framework (TPF) 2011-2012 http://thinphp.com
 * @package       app.model.base
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/base/IBaseDAO.php';
require_once BASE.'/app/model/base/DBFactory.php';

/** 
 * This Base DAO class. Model DAO classes must extend this class.
 */

class BaseDAO implements IBaseDao
{
	protected $dbh;
	protected $table;
	protected $lastSql;
    protected $lastError;
	
	/**
	 * Constructor to create a DAO for a specific table
	 * @param table Name of the table
	 */
	public function __construct($table)
	{
		$this->table = $table;
		$this->dbh = DBFactory::getDBHandler();
	}
	
	public function getLastSql()
	{
		return $this->lastSql;
	}

    public function getLastError()
	{
		return $this->lastError;
	}
	
	public function getDbHandler()
	{
		return $this->dbh;
	}

    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

	public function prepareExecute($sql, $paramArr)
	{
		if ($this->dbh == null) return;
        $this->lastSql = $sql;
        
		$stmt = $this->dbh->prepare($sql);
		if ($stmt != null) {
            $this->lastError = $stmt->errorInfo();

			$stmt->execute($paramArr);
            $this->lastError = $stmt->errorInfo();
			//$stmt->debugDumpParams();
		}
		return $stmt;
	}

    /**
     * get all rows with condition.
     * $users = $this->getAll('enabled = 1', 'userId DESC');
     */
	public function getAll($strWhere = '', $strOrderBy = '')
	{
		if ($this->dbh == null) return;
        if (isset($strWhere) && trim($strWhere) != '') $strWhere = ' WHERE '.$strWhere;
        if (isset($strOrderBy) && trim($strOrderBy) != '') $strOrderBy = ' ORDER BY '.$strOrderBy;

		$sql = 'SELECT * FROM ' . $this->table . $strWhere . $strOrderBy;

        $stmt = $this->prepareExecute($sql, null );
        if ($stmt && $stmt->rowCount() > 0) {
			return $stmt->fetchAll();
		}
		return null;
	}
	
	public function countAll()
	{
		if ($this->dbh == null) return;
		$sql = 'SELECT COUNT(*) FROM '.$this->table;

		$stmt = $this->prepareExecute($sql, null );
		if ($stmt && $stmt->rowCount() > 0) {
            return $stmt->fetchColumn();
		}
		return 0;
	}

	public function getById($id)
	{		
		if ($this->dbh == null) return;
		$sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->table.'Id = :id';

        $stmt = $this->prepareExecute($sql, array(':id'=>$id) );
        if ($stmt && $stmt->rowCount() > 0) {
            $res = $stmt->fetchAll();
            if ($res != null && count($res) >0) {
                return $res[0];
            }
        }
        return null;
	}

    /**
     * get rows have $fieldName = $val
     * example: $userList = $dao->getByField('userType', 1);
     * @return row(s) or null (if not found)
     */
    public function getByField($fieldName, $val)
	{
		if ($this->dbh == null) return;
		$sql = 'SELECT * FROM '.$this->table.' WHERE '.$fieldName.' = :val';

		$stmt = $this->prepareExecute($sql, array(':val'=>$val) );
        if ($stmt && $stmt->rowCount() > 0) {
            $res = $stmt->fetchAll();
            if ($res != null && count($res) >0) {
                return $res;
            }
        }
		return null;
	}

    /**
     * get the first row have $fieldName = $val
     * example: $loggedUser = $dao->getFirstByField('userId', $userId);
     * @return one row or null (if not found)
     */
    public function getFirstByField($fieldName, $val)
	{
        $res = $this->getByField($fieldName, $val);
        if ($res != null && count($res) >0) {
            return $res[0];
        }
        return null;
    }
			
    /**
     * get rows satisfied condition $cond
     * example: $disabledUsers = $dao->getWhere('disabled = 1');
     * @return row(s) or null (if not found)
     */
    public function getWhere($cond)
	{
		if ($this->dbh == null) return;
		$sql = 'SELECT * FROM '.$this->table.' WHERE '.$cond;

		$stmt = $this->prepareExecute($sql, null );
        if ($stmt && $stmt->rowCount() > 0) {
            $res = $stmt->fetchAll();
            if ($res != null && count($res) >0) {
                return $res;
            }
        }
		return null;
	}
			
	public function removeById($id)
	{
		$sql = 'DELETE FROM '.$this->table.' WHERE '.$this->table.'Id = :id';
        $stmt = $this->prepareExecute($sql, array(':id'=>$id) );
        return $this->lastError;
	}

    public function removeByField($fieldName, $val)
	{
		if ($this->dbh == null) return;
		$sql = 'DELETE FROM '.$this->table.' WHERE '.$fieldName.' = :val';
        $stmt = $this->prepareExecute($sql, array(':val'=>$val) );
        return $this->lastError;
	}
	
    public function removeWhere($cond)
	{
		if ($this->dbh == null) return;
		$sql = 'DELETE FROM '.$this->table.' WHERE '.$cond;
        $stmt = $this->prepareExecute($sql, null );
        return $this->lastError;
	}
	
	public function remove($obj)
	{
		// will be implemented by extending classes
		return;
	}
	
	public function create($obj)
	{
		// will be implemented by extending classes
		return;
	}
	
	public function update($updateClause, $paramArr)
	{
		$sql = 'UPDATE '.$this->table.' SET '.$updateClause;
		$stmt = $this->prepareExecute($sql, $paramArr);
        return $this->lastError;
	}

    /**
     * an useful function to execute UPDATE-SET query
     * by generating a full query, for example:
     *   $err = $dao->updateSet('parentId, level WHERE uid = :uid', $paramArr );
     * array $paramArr is a Key => Value array, has the same number of parameters in the string.
     */
    public function updateSet($strInput, $paramArr)
    {
        $pos = strpos($strInput, 'WHERE ');
        if ($pos > 0) {
            $strWhere = substr($strInput, $pos); // keep WHERE clause
            $strInput = str_replace($strWhere, '', $strInput); // remove WHERE clause
        }

        $arr = explode(',', $strInput);
        $str = ''; // build VALUES(...)
        for ($i = 0, $cnt = count($arr); $i < $cnt; $i++) {
            $field = trim($arr[$i]);
            $str .= ($i == 0 ? "$field = :$field" : ", $field = :$field" );
        }
        $sql = "UPDATE ".$this->table." SET $str $strWhere";
        $stmt = $this->prepareExecute($sql, $paramArr);
        return $this->lastError;
    }

    /**
     * an useful function to execute INSERT INTO query
     * by generating a full query, for example:
     *   $dao->insertInto('uid, email, password, createDT', $paramArr);
     *   note that $paramArr must have the same number of fields & same order.
     */
    public function insertInto($strInput, $paramArr)
    {
        $arr = explode(',', $strInput);
        $str = ''; // build VALUES(...)
        for ($i = 0, $cnt = count($arr); $i < $cnt; $i++) {
            $field = trim($arr[$i]);
            $str .= ($i == 0 ? ":$field" : ", :$field");
        }
        $sql = "INSERT INTO ".$this->table."($strInput) VALUES($str)";
        $stmt = $this->prepareExecute($sql, $paramArr);
        return $this->lastError;
    }

    public function insertUpdate($strInput, $paramArr)
    {
        $arr = explode(',', $strInput);
        $stValues = ''; // build VALUES(...)
        for ($i = 0, $cnt = count($arr); $i < $cnt; $i++) {
            $field = trim($arr[$i]);
            $stValues .= ($i == 0 ? ":$field" : ", :$field");
        }
        $stUpdate = ''; // build VALUES(...)
        for ($i = 0, $cnt = count($arr); $i < $cnt; $i++) {
            $field = trim($arr[$i]);
            $stUpdate .= ($i == 0 ? "$field = :$field" : ", $field = :$field" );
        }
        $sql = "INSERT INTO ".$this->table."($strInput) VALUES($stValues) ON DUPLICATE KEY UPDATE $stUpdate";
        $stmt = $this->prepareExecute($sql, $paramArr);
        return $this->lastError;
    }
}