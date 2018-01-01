<?php
namespace Presto\framework\database;

/*
 MIT License
 
 Copyright (c) 2017 Chris Strieter
 
 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:
 
 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 SOFTWARE.
 */

use Exception;
use Presto\framework\database\Database;
use Presto\framework\exception\DatabaseException;
use Presto\framework\exception\InvalidArgumentException;
use Presto\framework\exception\RecordNotFoundException;

/**
 * The BaseDAO object is a base data access object that performs some operations against the database 
 * object such as queries, inserts, updates, etc.
 * 
 * @author Admin
 *
 */
class BaseDAO 
{
    
    var $status = null;
    var $tablename = null;
    var $database = null;
    
    function getDatabase() {
        return $this->database;
    }
    function setDatabase(Database $db) {
        $this->database = $db;
    }
    
    /**
     * This function will return the ID from the Joomla database object of a row that was
     * just inserted into the database.
     *
     * @return int
     */
    function getInsertId() {
        $db	= $this->database;
        return $db->insertid();
    }
    /**
     * This function will locate a specific object by its id and return an instance of the
     * object.
     *
     * @param int $id
     * @return Object
     */
    function findById($id) {
        if (!is_numeric($id)) {
            throw new InvalidArgumentException("Invalid ID passed to BaseDAO:findById");
        }
        $iid = (int) $id;
        $query	= 'SELECT * FROM ' .$this->getNameQuote( $this->tablename  ) . ' where id = ' . $iid	;
        
        // 		try {
        // 			$row = $cache->get($query);
        // 			return $row;
        // 		} catch (Exception $e) {
        // 			try {
        $row = self::_getRow($query);
        // 			} catch (Exception $e) {
        // 				throw $e;
        // 			}
        return $row ;
        // 		}
        
    }
    
    /**
     * This function will return an array of objects for ALL rows within the underlying
     * table.
     *
     * @return array
     */
    function getRows()
    {
        // 		require_once(JLEAGUE_CLASSES_OBJECTS_PATH . DS . 'cache.class.php');
        // 		$cache = & JLCache::getInstance();
        
        $query = 'SELECT * FROM ' . $this->getNameQuote( $this->tablename );
        
        // 		try {
        // 			$rows = $cache->get($query);
        // 			return $rows;
        // 		} catch (Exception $e) {
        return self::_getRows($query);
        // 		}
    }
    
    
    /**
     * This fucntion will retrieve a specific group of records that are defined by the
     * start and stop parameters.
     *
     * @param int $start
     * @param int $stop
     * @param string $orderby
     * @param array $filter
     * @return array
     */
    function getRecords($start, $stop, $orderby = '', $filter = '') {
        if (is_array($filter)) {
            $cond = $this->createFilterWhereClase($filter);
            if ($cond != null) {
                $filter = ' where ' . $cond;
            }
        }
        $query = 'SELECT * from ' . $this->getNameQuote($this->tablename) . ' ' . $filter . ' ' . $orderby . ' LIMIT ' . $start . ',' . $stop;
        /* 7/2/2016 */
        //echo $query;
        return self::_getRows($query);
    }
    
    /**
     * This function will accept an SQL query and insert the row.
     *
     * @param string $query
     * @return boolean
     */
    protected function _insertRow($query) {
        $db	= $this->getDatabase();
          
        $db->setQuery($query);
        if (!$db->query()) {
            $this->status = $db->getErrorMsg();
            throw new DatabaseException($db->getErrorMsg());
        } else {
            return true;
        }
    }

    /**
     * This function is to enable an update query to be processed.
     *
     * @param string $query
     * @return boolean
     */
    protected function _updateRow($query) {
        $result = null;
        $db	= $this->getDatabase();
        $db->setQuery($query);
        if (!$db->query()) {
            $this->status = $db->getErrorMsg();
            throw new Exception($db->getErrorMsg());
        } else {
            $this->status = null;
            return true;
        }
    }
    
    /*
     function getRow($query) {
     global $database;
     $database->setQuery($query);
     $rows = $database->loadObjectList();
     if (sizeof($rows)>0) {
     $obj = $this->loadObject($rows[0]);
     return $obj;
     } else {
     return null;
     }
     }
     */
    
    protected function _getRow($query) {
        $result = null;
        $db	= $this->database;
        $db->setQuery( $query );
        try {
            $rows	= $db->loadObjectList();
        } catch (Exception $e) {
            throw $e;
        }
        // 		if( $db->getErrorNum() )
            // 			throw new Exception($db->getErrorMsg());
        if (count($rows)>0) {
            $result = $this->loadObject($rows[0]);
        } else {
            throw new Exception("Row Not Found");
        }
        return $result;
    }
    
    
    protected function _deleteRow($query) {
        $result = null;
        $db	= $this->database;
        $db->setQuery($query);
        if (!$db->query()) {
            $this->status = $db->getErrorMsg();
            throw new Exception($db->getErrorMsg());
        } else {
            $this->status = null;
            return true;
        }
    }
    
    /**
     * This is a protected function that uses Joomla key database functions to return rows based on the query argument.
     *
     * @param String $query
     * @return array
     */
    protected function _getRows($query) {
        $db	= $this->database;
        $rowArray = array();
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        if( $db->getErrorNum() ) {
            //JError::raiseError( 500, $db->stderr());
            throw new Exception($db->getErrorMsg());
        }
        
        try {
            for ($y=0; $y<(sizeof($rows)); $y++) {
                try {
                    $rowArray[$y] = $this->loadObject($rows[$y]);
                } catch (Exception $e1) {
                    throw $e1;
                }
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $rowArray;
    }
    
    protected function exec($query) {
        $db = $this->getDatabase();
        try {
            $db->setQuery($query);
            $rows = $db->loadObjectList();
        }
        catch (RecordNotFoundException $re) {
            throw $re;
        }
        catch (Exception $e) {
            throw new DatabaseException($e->getMessage());
        }
        return $rows;
    }
    
    
    protected function _execute($query) {
        // 		require_once(JLEAGUE_CLASSES_OBJECTS_PATH . DS . 'cache.class.php');
        // 		$cache = & JLCache::getInstance();
        // 		try {
        // 			$rows = $cache->get($query);
        // 			return $rows;
        // 		} catch (Exception $e) {
        $db = $this->database;
        try {
            $db->setQuery($query);
            $rows = $db->loadObjectList();
            // 			if( $db->getErrorNum() ) {
            // 				JError::raiseError( 500, $db->stderr());
            // 				return false;
            // 			}
            return $rows;
        } catch (Exception $e) {
            throw $e;
        }
        // 		}
    }
    
    /**
     * The togglePublished function will flip the published value based on its current state
     *
     * @param int $id
     * @return boolean
     */
    function togglePublished($id) {
        $iid = (int) $id;
        $obj = $this->findById($id);
        if ($obj->getPublished()==0)
            $obj->setPublished(1);
            else
                $obj->setPublished(0);
                $query	= 'update ' .$this->getNameQuote( $this->tablename  ) . ' set published=' . $obj->getPublished() . ' where id = ' . $iid	;
                try {
                    self::_updateRow($query);
                } catch (Exception $e) {
                    throw $e;
                }
    }
    
    function publish($id) {
        $iid = (int) $id;
        $query	= 'update ' .$this->getNameQuote( $this->tablename  ) . ' set published=1 where id = ' . $iid	;
        try {
            self::_updateRow($query);
        } catch (Exception $e) {
            throw $e;
        }
    }
    function unpublish($id) {
        $iid = (int) $id;
        $query	= 'update ' .$this->getNameQuote( $this->tablename  ) . ' set published=0 where id = ' . $iid	;
        try {
            self::_updateRow($query);
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    function delete($id) {
        $iid = (int) $id;
        $query	= 'delete from ' .$this->getNameQuote( $this->tablename  ) . ' where id = ' . $iid	;
        try {
            self::_deleteRow($query);
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    /**
     * This function will return the # of rows in a specific table.
     *
     * @return unknown
     */
    function getTableSize($filter = null) {
        $query	= 'select * from ' .$this->getNameQuote( $this->tablename  );
        $db	= $this->database;
        $db->setQuery($query);
        $rows = $db->loadObjectList();
        return sizeof($rows);
    }
    
    function getStatus() {
        return $this->status;
    }
    
    function getNameQuote($val) {
        return $val;
        $db	= $this->database;
        return $db->nameQuote($val);
    }
    
    /**
     * This function will create a clause that can be included in an SQL statement.  It is based
     * on SQL conditions that are added to an array.  It is assumed that the elements within the
     * array are in the format of "<column> <operator> <value>".  i.e. status = 'P'.  If multiple
     * elements are in the array, they will be joined in the clause with an " and " statement.
     *
     * @param array $filter
     * @return string
     */
    protected function createFilterWhereClase($filter) {
        if (sizeof($filter)>0) {
            $value = implode(" and ",$filter);
            return $value;
        }
        return '';
    }
  
    
    function setTableName($name) {
        $this->tablename = $name;
    }
    function getTableName() {
        return $this->tablename;
    }
    
    
}