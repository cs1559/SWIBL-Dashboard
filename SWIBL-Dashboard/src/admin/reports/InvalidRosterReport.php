<?php
namespace swibl\admin\reports;

use Presto\framework\reports\Report;
use Presto\framework\reports\datasource\DatabaseDataSource;
use swibl\admin\dashboard\DashboardService;
use Presto\framework\exception\InvalidArgumentException;
use Presto\framework\reports\ReportBuildFailureException;
use Presto\framework\reports\ReportContext;

class InvalidRosterReport extends Report {
    
    var $queryStr = "select report_table.*, s.title as season from (
select teamid, dm.season as seasonid, t.name as teamname, t.coachname, d.agegroup as agegroup, d.name as divisionname, regular, substitute, total_players, emailcount
from (
         select teamid, season, sum(regular) as regular, sum(substitute) as substitute, sum(total_players) as total_players, sum(emailcount) as emailcount
         from (
        	select teamid, season, sum(regular) as regular, sum(substitute) as substitute, sum(total_players) as total_players, 0 as emailcount
        	from (
        		SELECT teamid, season,if(classification='P',1,0) as regular, if(classification='S',1,0) as substitute, 1 as total_players
        		FROM swibl_v1.joom_jleague_simple_roster
        		WHERE season = {SEASONID}
        	) as temp1
            group by teamid, season
            UNION
            select teamid, season, 0 as regular, 0 as substitute, 0 as total_players, emailcount
            from (
        	    select season, teamid, email, count(*) AS EMAILCOUNT
        		FROM swibl_v1.joom_jleague_simple_roster
        			WHERE
        				SEASON = {SEASONID} and email <> ''
        			GROUP BY SEASON, TEAMID, email
        			HAVING EMAILCOUNT > 3
                ) as temp2
        ) as mainsubselect	
            group by teamid, season 
) as temp2, swibl_v1.joom_jleague_teams t, swibl_v1.joom_jleague_division d, swibl_v1.joom_jleague_divmap dm
where temp2.teamid = dm.team_id
and temp2.season = dm.season
and dm.team_id = t.id
and dm.published = 1
and dm.division_id = d.id
and dm.season = {SEASONID}
UNION ALL
select t.id as teamid, dm.season as seasonid, t.name, t.coachname, d.agegroup, d.name as division_name, 0, 0, 0, 0
from 
	swibl_v1.joom_jleague_teams t, swibl_v1.joom_jleague_division d, swibl_v1.joom_jleague_divmap dm
where dm.team_id = t.id
	and dm.division_id = d.id
	and dm.season = {SEASONID}
        and dm.published = 1
	and dm.team_id not in (
	select distinct teamid from swibl_v1.joom_jleague_simple_roster where season = {SEASONID}
)
) report_table, swibl_v1.joom_jleague_seasons s
where report_table.seasonid = s.id
order by agegroup, teamname
        ";
    
    
    function __construct(ReportContext $context) {
        $seasonid = $context->getParam("seasonid");
        $agegroup = $context->getParam("agegroup");
        if (!is_numeric($seasonid)) {
            throw new InvalidArgumentException("Invalid, or missing, Season Id");
        }
        
        $svc = DashboardService::getInstance();  
        $this->setDatasource(new DatabaseDataSource($svc->getDatabase()));
        $this->setParam("SEASONID", $seasonid);
        if (!is_null($agegroup)) {
            $this->setParam("AGEGROUP", $agegroup);
        } else {
            $this->setParam("AGEGROUP","");
        }
        try {
            $this->execute();
            $this->createFilters();
        } catch (\Exception $e) {
            throw new ReportBuildFailureException($e->getMessage());
        }
    }
    
    
    function execute() {
        $query = $this->queryStr;
        foreach ($this->params as $param => $value) {
            $searchTag = "/{" . $param . "}/";
            $query = preg_replace($searchTag, $value, $query);
        }
        try {
            $ds = $this->getDatasource();
            $ds->setQuery($query);
            $this->resultSet = $ds->executeQuery();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    function createFilters() {
        return true;
//         $ds = $this->getDatasource();
//         $ds->setQuery("select DISTINCT season, seasonid from division_stats order by season desc");
//         $seasons = $ds->executeQuery();
//         $season = array();
//         foreach ($seasons as $row) {
//             $season[] = $row;
//         }
//         $this->filters["seasonid"] = $season;
    }
    

}