<?php
namespace swibl\admin\reports;

use Presto\framework\reports\Report;
use Presto\framework\reports\datasource\DatabaseDataSource;
use swibl\admin\dashboard\DashboardService;
use Presto\framework\exception\InvalidArgumentException;
use Presto\framework\reports\ReportBuildFailureException;
use Presto\framework\reports\ReportContext;

class DoubleRosterReport extends Report {
    
    var $queryStr = "select * from (
    SELECT soundex(concat(lastname,firstname)) as keyfld, lastname, firstname, teamid, t.name as teamname, d.name as divisionname, d.agegroup, d.sort_order
    FROM swibl_v1.joom_jleague_simple_roster r, swibl_v1.joom_jleague_divmap dm, swibl_v1.joom_jleague_division d, swibl_v1.joom_jleague_teams t
    WHERE dm.season = {SEASONID}
       and dm.team_id = r.teamid
       and dm.season = r.season
       and dm.division_id = d.id
       and dm.team_id = t.id
     ) tmptbl
 where keyfld in (
       select key1 from (
		select key1, count(*) from (
				select soundex(concat(lastname,firstname)) as key1 
				from swibl_v1.joom_jleague_simple_roster r
				where season = {SEASONID}
			) tmp1
		group by key1
		having count(*) > 1
      ) tmp2
 )
order by lastname, firstname, keyfld
        ";
    
    //and agegroup like '{AGEGROUP}%'
    
    
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