<?php
/** 
 * Thin PHP Framework (TPF) 2011 http://thinphp.com
 *
 * Licensed under TPF License at http://bit.ly/TPFLicense
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Thin PHP Framework Team
 * @link          http://thinphp.com
 * @package       app.model.base.mongo
 * @license       TPF License http://bit.ly/TPFLicense
 */
defined('BASE') or exit('Direct script access is not allowed!');
require_once BASE.'/app/model/base/mongo/MongoDBFactory.php';

// This is Base DAO for MongoDB
class MongoDAO
{
	protected $dbh;
    protected $colh;
	protected $collectionName;
	protected $dateTimeField; // used for sorting, getFirst...
	
	public function __construct($collectionName, $dateTimeField)
	{
		$this->collectionName = $collectionName;
		$this->dateTimeField = ($dateTimeField != null ? $dateTimeField : null);
        
		$this->dbh = MongoDBFactory::getDBHandler();
        $this->colh = $this->dbh->$collectionName;
    }

    public function getDbHandler()
	{
		return $this->dbh;
	}

    public function collection()
	{
		return $this->colh;
	}

    public function mongoEval($code, $args)
    {
        return $this->dbh->command(array('$eval' => $code, args => $args));
    }

    /*
     * get next value of $counterName
     * requirement: collection 'counter', initialized with: db.counter.insert({_id: "nodeId", c: 100});
     * example: nextCounter('nodeId')
     */
    public function nextCounter($counterName)
    {
        // source: http://bit.ly/qBEmoK
        // source: http://bit.ly/7w317K
        // mongo: ret = db.counter.findAndModify({query:{_id:$counterName}, update:{$inc : {c:1}}, "new":true, upsert:true});
        $ret = $this->dbh->command(array('findandmodify' => 'counter',
                    'query' => array('_id'=>$counterName),
                    'update'=> array('$inc'=>array('c'=>1)),
                    'new'=>true, 'upsert'=>true ));
        if ($ret != null && $ret['ok'] != null && $ret['ok'] == 1) {
            return $ret['value']['c'];
        }
        return -1; // error
    }

    /*
     * find rows with condition ($query), $fields is optional.
     * example: $users = $mdao->find(array('sex'=>$sex));
     */
    public function find($query, $fields)
    {
        if (isset($query)) {
            if (isset($fields)) {
                return $this->colh->find($query, $fields);
            }
            return $this->colh->find($query);
        } else {
            return $this->colh->find();
        }
    }

	public function getAll()
	{
		// find everything in the collection
		return $this->colh->find();
	}
	
	/**
     * get the first row have $fieldName = $val
     * requirement: $this->dateTimeField
     * example: $user = $dao->getFirstByField('userId', $userId);
     * @return one row or null (if not found)
     */
    public function getFirstByField($fieldName, $val)
    {
        $cur = $this->find( array($fieldName => $val) )->sort( array($this->dateTimeField => -1) )->limit(1);
        if ($cur != null && count($cur) == 1) return $cur->getNext();
        return null;
    }
    
    public function getFirstById($id) {
    	return $this->getFirstByField( $collectionName.'Id' );
    }

    public function countAll()
	{
        return $this->colh->count();
    }

    // Example: $row = getById('47cc67093475061e3d9536d2');
    public function getById($mongoId)
    {
        return $this->colh->findOne( array('_id' => new MongoId($mongoId)) );
    }
    
    public function removeByField($fieldName, $val, $options)
    {
        if (isset($options)) {
            return $this->colh->remove( array($fieldName => $val, $options) );
        }
        return $this->colh->remove( array($fieldName => $val) );
    }

    public function removeByMongoId($mongoId, $options)
    {
        if (isset($options)) {
            return $this->colh->remove( array('_id' => new MongoId($mongoId)), $options );
        }
        return $this->colh->remove( array('_id' => new MongoId($mongoId)) );
    }

    public function insert($doc)
    {
        $this->colh->insert($doc);
    }
    
    /**
     * update a Document with updated fields $arr (keep other fields), safe = true, multiple = false
     * example: $mdao->safeUpdateDoc( array('name','newname'), array('uid'=>$uid) );
     * @return one row or null (if not found)
     */
    public function safeUpdateDoc($arr, $arrCond)
    {
    	return $this->colh->update( $arrCond,
    		array('$set' => $arr),
    		array('safe' => true, 'multiple' => false));
    }
}
