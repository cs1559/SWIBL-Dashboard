<?php
namespace Presto\framework\reports;

use Presto\framework\reports\datasource\DataSourceInterface;

interface ReportInterface {
    
    // Sets the datasource used generating the report contents
    function setDatasource(DataSourceInterface $ds);
    
    // Returns the datasource which sources data in the report
    function getDatasource();
    
    // Sets the parameter(s) used in generating the report or filtering the data returned by the report
    function setParam($name, $value);
    
    // Sets the report name
    function setReportName($name);
    
    // Returns the name of the report
    function getReportName();
    
    // Sets the report title
    function setReportTitle($title);
    
    // should return the title of the report
    function getReportTitle();
    
    // funciton is used to return the actual data that is output on a report
    function getResultSet();
    
}