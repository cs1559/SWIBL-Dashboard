<?php
namespace swibl\admin\reports;

use Presto\framework\reports\Report;
use Presto\framework\reports\datasource\DatabaseDataSource;
use swibl\admin\dashboard\DashboardService;
use Presto\framework\exception\InvalidArgumentException;
use Presto\framework\reports\ReportBuildFailureException;
use Presto\framework\reports\ReportContext;

class ListDivisionsBySeason extends Report {
    
    var $queryStrX = "select division_id, d.name,  d.sort_order, d.agegroup, count(team_id) total_teams 
    	from swibl_v1.joom_jleague_divmap dm, swibl_v1.joom_jleague_division d
    		where dm.season = {SEASONID}
    			and dm.division_id = d.id
    			and dm.published = 1 
    		group by division_id, d.name, d.sort_order, d.agegroup
    		order by d.sort_order";
    
    var $queryStr = "select * from swibl_dashboard.division_stats 
            where seasonid = {SEASONID} and number_of_teams > 0
            order by sort_order";
    

    
    function __construct(ReportContext $context) {
        $seasonid = $context->getParam("seasonid");
        if (!is_numeric($seasonid)) {
            throw new InvalidArgumentException("Invalid, or missing, Season Id");
        }
        
        $svc = DashboardService::getInstance();  
        $this->setDatasource(new DatabaseDataSource($svc->getDatabase()));
        $this->setParam("SEASONID", $seasonid);
        try {
            $this->execute();
            $this->createFilters();
        } catch (\Exception $e) {
            throw new ReportBuildFailureException();
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
        $ds = $this->getDatasource();
        $ds->setQuery("select DISTINCT season, seasonid from division_stats order by season desc");
        $seasons = $ds->executeQuery();
        $season = array();
        foreach ($seasons as $row) {
            $season[] = $row;
        }
        $this->filters["seasonid"] = $season;
    }
    

}