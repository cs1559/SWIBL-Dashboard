<?php
namespace swibl\admin\reports;

use Presto\framework\reports\Report;
use Presto\framework\reports\datasource\DatabaseDataSource;
use swibl\admin\dashboard\DashboardService;
use Presto\framework\exception\InvalidArgumentException;
use Presto\framework\reports\ReportBuildFailureException;
use Presto\framework\reports\ReportContext;

class LeagueVenueList extends Report {
    
   
    var $queryStr = "SELECT * FROM swibl_v1.joom_gmaps_markers WHERE published = 1 order by name";
   
    function __construct(ReportContext $context = null) {

        $svc = DashboardService::getInstance();  
        $this->setDatasource(new DatabaseDataSource($svc->getDatabase()));
        try {
            $this->execute();
            $this->createFilters();
        } catch (\Exception $e) {
            throw new ReportBuildFailureException();
        }
    }
    
    
    function execute() {
        $query = $this->queryStr;
        if (count($this->params) > 0) {
            foreach ($this->params as $param => $value) {
                $searchTag = "/{" . $param . "}/";
                $query = preg_replace($searchTag, $value, $query);
            }
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
    }
    

}