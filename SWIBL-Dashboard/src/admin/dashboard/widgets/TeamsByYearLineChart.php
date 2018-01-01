<?php
namespace swibl\admin\dashboard\widgets;
/*
 * TeamsByAgeGroupPieChart
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */

use Presto\framework\charts\Data;
use Presto\framework\charts\DataItem;
use Presto\framework\charts\DataSet;
use Presto\framework\charts\LineChart;
use Presto\framework\charts\MissingContextException;
use swibl\admin\dashboard\DashboardStatsDAO;
use Presto\framework\exception\DatabaseException;
use swibl\admin\dashboard\DashboardService;

class TeamsByYearLineChart extends LineChart {
    
    var $database;
    var $seasonid;
    var $rawdata;
    var $colors = array(
        '#ff0000',
        '#0000ff',
        '#3cb371',
        '#ee82ee',
        '#ffa500',
        '#d9534f',
        '#80dbca',
        '#6a5acd',
        '#6d0cb0',
        '#ebc234',
        '#d0aedb'
    );
    
    public function __construct($seasonid) {
        parent::__construct();
        $svc = DashboardService::getInstance();
        $this->db = $svc->getDatabase();
        $this->setSeasonId($seasonid);
        $this->retrieveData();
        $this->setElementId("teams-by-year-linechart");
    }
    
    private function setSeasonId($seasonid) {
        $this->seasonid = $seasonid;
    }
    function getSeasonId() {
        return $this->seasonid;
    }
    
    private function retrieveData() {
        if (is_null($this->seasonid)) {
            throw new MissingContextException("Season ID is not set");
        }
        try {
            $dao = DashboardStatsDAO::getInstance($this->db);
            $this->rawdata = $dao->getTeamCountsBySeasons($this->seasonid);
            $this->loadData();
        } catch (DatabaseException $e) {
            $this->data = null;
        }
    }
    
    private function loadData() {
        //agegroup, number_of_teams
        
        $ds = new DataSet();
        $ds->setLabel("Number of Teams");
        
        $data = new Data();
        
        $idx = 0;
        foreach ($this->rawdata as $row) {
            $ds->addDataItem(new DataItem($row->season_name, $row->number_of_teams));
            $data->addLabel($row->season_name);
            $idx = $idx+1;
        }
        
        $data->addDatasets($ds);
        $this->setData($data);
        
    }
    
}