<?php
namespace Presto\framework\reports\datasource;

use Presto\framework\database\Database;
use Presto\framework\exception\DatabaseException;
use Presto\framework\reports\datasource\DataSourceInterface;

class DatabaseDataSource implements DataSourceInterface 
{
    
    var $database;
    var $query;
    
    /**
     * @return string $query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    public function __construct(Database $db = null) {
        if (!is_null($db)) {
            $this->setDatabase($db);
        }
    }
    
    public function executeQuery()
    {
        if (is_null($this->query)) {
            throw new DatabaseException("QUERY HAS NOT BEEN SET");
        }
        $db = $this->getDatabase(); 
        try {
            $db->setQuery($this->query);
            return $db->loadObjectList();
        } catch (\Exception $e) {
            throw $e;
        }  
    }
    /**
     * @return Database $database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param Database $database
     */
    public function setDatabase(Database $database)
    {
        $this->database = $database;
    } 
    
}