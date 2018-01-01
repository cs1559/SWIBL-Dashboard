<?php
namespace swibl\client\teams;

/*
 * swibl\standings\StandingsDAO
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */


use Presto\framework\database\Database;
use Presto\framework\database\BaseDAO;
use Presto\framework\exception\InvalidArgumentException;

class TeamAPI extends BaseDAO {

    
    /**
     * Private constructor to ensure that the object cannot be instantiated by a client.
     */
    private function __construct() {
    }
    
    static function getInstance(Database $db) {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new TeamAPI();
        }
        $instance->setDatabase($db);
        $instance->setTableName("joom_jleague_teams");
        return $instance;
    }
    
    
    function getTeamsInDivision($season, $divisionid = null) {
        if (!is_numeric($season)) {
            throw new InvalidArgumentException("Invalid Season ID - getTeamsInDivision");
        }
        if ($divisionid != null) {
            if (!is_numeric($divisionid)) {
                throw new InvalidArgumentException("Invalid Division ID - getTeamsInDivision");
            }
        }
        if ($divisionid != null) {
            $query = "select * from " . $this->getTableName() .
            " where id in (select team_id from joom_jleague_divmap where season  = " . $season . " and " .
            " division_id = " . $divisionid . " and published = 1)";
        } else {
            $query = "select * from " . $this->getTableName() .
            " where id in (select team_id from joom_jleague_divmap where season  = " . $season . " and " .
            " published = 1)";
        }
        $db = $this->getDatabase();
        $db->setQuery($query);
        try {
            $results = $db->loadObjectList();
            $object = TeamHelper::bindArray($results);
        } catch (\Exception $e) {
            throw $e;
        }
        return $object;
    }
       
}