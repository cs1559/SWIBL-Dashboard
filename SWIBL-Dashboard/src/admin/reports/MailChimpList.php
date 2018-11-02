<?php
namespace swibl\admin\reports;

use Presto\framework\reports\Report;
use Presto\framework\reports\ReportBuildFailureException;
use Presto\framework\reports\datasource\DatabaseDataSource;
use swibl\admin\dashboard\DashboardService;
use Presto\framework\exception\InvalidArgumentException;
use Presto\framework\reports\CSVReportInterface;
use Presto\framework\reports\ReportContext;

class MailChimpList extends Report implements CSVReportInterface {
    
    var $list="default";
    var $queryStr = "";
    /*
     *         
     *         
        SELECT email, split_str(d1.name,' ',1) as fname, split_str(d2.name,' ',2) as lname, phone, city, upper(state) as state, d2.name as "division_name", s1.title as "season" from swibl_v1.joom_jleague_divmap as d1, swibl_v1.joom_jleague_division as d2, swibl_v1.joom_jleague_seasons as s1
        where d1.season = 22
           and d1.division_id = d2.id
	   and d1.season = s1.id
	   union
	   SELECT tc1.email, split_str(tc1.name,' ',1) as fname, split_str(tc1.name,' ',2) as lname, ' ' as phone, '' as city, '' as state, d2.name as "division_name", s1.title as "season" 
from swibl_v1.joom_jleague_teamcontacts as tc1, swibl_v1.joom_jleague_divmap as d1, swibl_v1.joom_jleague_division as d2, swibl_v1.joom_jleague_seasons as s1
        where d1.season = 22
	   and tc1.teamid = d1.team_id
           and d1.division_id = d2.id
	   and d1.season = s1.id



        SELECT email, split_str(name,' ',1) as fname, split_str(name,' ',2) as lname, phone, city, upper(state) as state from swibl_v1.joom_jleague_divmap
        where season = {SEASONID}
        union
        SELECT email, split_str(name,' ',1) as fname, split_str(name,' ',2) as lname, ' ' as phone, '' as city, '' as state from swibl_v1.joom_jleague_teamcontacts
        where teamid in (
            select team_id from swibl_v1.joom_jleague_divmap where season = {SEASONID}
            )
        ) as tmp1
        

     * 
     */
    var $coachQuery =
    "select * from
    (
        SELECT email, split_str(d1.name,' ',1) as fname, split_str(d2.name,' ',2) as lname, phone, city, upper(state) as state, d2.name as 'division_name', s1.title as 'season' from swibl_v1.joom_jleague_divmap as d1, swibl_v1.joom_jleague_division as d2, swibl_v1.joom_jleague_seasons as s1
        where d1.season = {SEASONID}
           and d1.division_id = d2.id
	       and d1.season = s1.id
	   union
	   SELECT tc1.email, split_str(tc1.name,' ',1) as fname, split_str(tc1.name,' ',2) as lname, ' ' as phone, '' as city, '' as state, d2.name as 'division_name', s1.title as 'season' 
            from swibl_v1.joom_jleague_teamcontacts as tc1, swibl_v1.joom_jleague_divmap as d1, swibl_v1.joom_jleague_division as d2, swibl_v1.joom_jleague_seasons as s1
            where d1.season =  {SEASONID}
	           and tc1.teamid = d1.team_id
               and d1.division_id = d2.id
	           and d1.season = s1.id
        ) as tmp1
        where length(email)>0
        and LOCATE(';', email) <= 0
        and LOCATE('@', email) > 0
        and LOCATE(' or ', email) <= 0
        group by email";
        
    var $parentQuery = "select email from swibl_v1.joom_jleague_simple_roster where season = {SEASONID}
         AND EMAIL IS NOT NULL AND EMAIL <> ''";
      
    function __construct(ReportContext $context) {
        $seasonid = $context->getParam("seasonid");
        if (!is_numeric($seasonid)) {
            throw new InvalidArgumentException("INVALID SEASON ID");
        }
        
        $list = $context->getParam("list");
        if ($list == "parents") {
            $this->queryStr = $this->parentQuery;
            $this->list = $list;
        } else {
            $this->queryStr = $this->coachQuery;
        }
        $svc = DashboardService::getInstance();
        $this->setDatasource(new DatabaseDataSource($svc->getDatabase()));
        $this->setParam("SEASONID", $seasonid);
        try {
            $this->execute();
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
        $svc = DashboardService::getInstance();
        $logger = $svc->getLogger();
        $logger->debug($query);
        try {
            $ds = $this->getDatasource();
            $ds->setQuery($query);
            $this->resultSet = $ds->executeQuery();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function outputToCSV()
    {
        $output = "";
        switch ($this->list) {
            case "parents":
                $output = $this->formatParents();
                break;
            default:
                $output = $this->formatDefault();
                break;
        }
        return $output;
        
    }

    private function formatDefault() {
        $output = "";
        // email, fname, lname, phone, city, state
        $headerRow = "email,fname,lname,phone,city,state,season,division_name";
        $output = $output . $headerRow . "\r\n";
        
        // Build formatted rows.
        foreach ($this->getResultSet() as $row) {
            $tmp = array(
                $row->email,
                $row->fname,
                $row->lname,
                $row->phone,
                $row->city,
                $row->state,
                $row->season,
                $row->division_name
            );
            $csv = implode(",", $tmp);
            $output = $output . $csv . PHP_EOL;
        }
        return $output;
    }
    
    private function formatParents() {
        // email, fname, lname, phone, city, state
        $headerRow = "email";
        $output = $output . $headerRow . "\r\n";
        
        // Build formatted rows.
        foreach ($this->getResultSet() as $row) {
            $tmp = array(
                $row->email
            );
            $csv = implode(",", $tmp);
            $output = $output . $csv . "\r\n";
        }
        return $output;
    }
       
}