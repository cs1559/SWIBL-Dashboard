<?php
namespace swibl\admin\dashboard;

use Presto\framework\database\Database;
use Presto\framework\database\BaseDAO;
use Presto\framework\exception\DatabaseException;
use Presto\framework\exception\InvalidArgumentException;

class DashboardStatsDAO extends BaseDAO 
{
    
    /**
     * Private constructor to ensure that the object cannot be instantiated by a client.
     */
    private function __construct() {
    }
    
    static function getInstance(Database $db) {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new DashboardStatsDAO();
        }
        $instance->setDatabase($db);
        $instance->setTableName("dashboard_stats");
        return $instance;
    }		
    
    function getSeasonStatistics($seasonid) {
        if (is_null($seasonid)) {
            throw new InvalidArgumentException();
        }
        try {
            $rows = self::exec("select * from dashboard_stats where seasonid = " . $seasonid);
        } catch (DatabaseException $e) {
            throw $e;
        }
        $row = $rows[0];
        $stats = new SeasonStats();
        $stats->setSeasonid($row->seasonid);
        $stats->setSeason($row->season);
        $stats->setDataAsOf($row->data_as_of);
        $stats->setTotalTeams($row->number_of_teams);
        $stats->setTotalDivisions($row->number_of_divisions);
        $stats->setTotalGamesScheduled($row->number_of_games_scheduled);
        $stats->setTotalGamesPlayed($row->number_of_games_played);
        $stats->setAverageRunDifferential($row->average_run_differential);
        $stats->setAverageRosterSize($row->average_roster_size);
        return $stats;
    }
    
    /**
     * 
     * @param int $seasonid
     * @throws InvalidArgumentException
     * @throws DatabaseException
     * @return array
     */
    function getTeamCountsByAgeGroup($seasonid) {
        if (!is_numeric($seasonid)) {
            throw new InvalidArgumentException();
        }
        if (is_null($seasonid)) {
            throw new InvalidArgumentException();
        }
        try {
            $rows = self::exec("SELECT agegroup, sum(number_of_teams) as number_of_teams FROM `division_stats` WHERE seasonid = " . $seasonid . " group by agegroup ");
        } catch (DatabaseException $e) {
            throw $e;
        }
        return $rows;
    }
   
    function getTeamCountsBySeasons() {
        try {
            $queryStr = "select season, title as season_name, number_of_teams
                from (
                    select season, count(*) number_of_teams from swibl_v1.joom_jleague_divmap
                    where published = 1
                    group by season
                    ) a, swibl_v1.joom_jleague_seasons s
                    where a.season = s.id";
            $rows = self::exec($queryStr);
        } catch (DatabaseException $e) {
            throw $e;
        }
        return $rows;
    }
    
}