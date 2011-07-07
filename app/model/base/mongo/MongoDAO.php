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
	
	public function __construct($collectionName)
	{
		$this->collectionName = $collectionName;
        
		$this->dbh = MongoDBFactory::getDBHandler();
        $this->colh = $this->dbh->$collectionName;
    }

    public function find($query, $fields)
    {
        if (isset($fields)) {
            return $this->colh->find($query, $fields);
        }
        return $this->colh->find($query);
    }

	public function getAll()
	{
		// find everything in the collection
		return $this->colh->find();
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

    public function removeById($mongoId, $options)
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
}
