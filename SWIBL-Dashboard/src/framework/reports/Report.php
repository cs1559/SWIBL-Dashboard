<?php
namespace Presto\framework\reports;

use Presto\framework\exception\InvalidArgumentException;
use Presto\framework\reports\datasource\DataSourceInterface;

abstract class Report implements ReportInterface {
    
    var $reportname;
    var $reporttitle;
    var $datasource;
    var $params;
    var $resultSet;
    var $requiredParams;
    var $filters = array();
 
    
    /**
     * Returns the REPORT NAME
     * @return string $reportname
     */
    public function getReportName()
    {
             return $this->reportname;
    }

    /**
     * Returns the REPORT TITLE
     * @return string $reporttitle
     */
    public function getReportTitle()
    {
        return $this->reporttitle;
    }

    /**
     * Returns the datasource object used to source the data for the report.
     * @return DataSourceInterface $datasource
     */
    public function getDatasource()
    {
        return $this->datasource;
    }

    /**
     * Returns an array of parameters (name/value pair) used in a  report.
     * @return array $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return the $resultSet
     */
    public function getResultSet()
    {
        return $this->resultSet;
    }

    /**
     * @param string $reportname
     */
    public function setReportName($reportname)
    {
        $this->reportname = $reportname;
    }

    /**
     * @param string $reporttitle
     */
    public function setReportTitle($reporttitle)
    {
        $this->reporttitle = $reporttitle;
    }

    /**
     * @param DataSourceInterface $datasource
     */
    public function setDatasource(DataSourceInterface $datasource)
    {
        $this->datasource = $datasource;
    }

    /**
     * @param field_type $resultSet
     */
    public function setResultSet($resultSet)
    {
        $this->resultSet = $resultSet;
    }

    /**
     * This function will set a name/value pair (parameter) used in generating the resultset.
     * @param string $name
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    function setParam($name, $value) {
        if (!is_string($name)) {
            throw new InvalidArgumentException("INVALID PARAMETER NANE");
        }
        if (is_null($value)) {
            throw new InvalidArgumentException("PARAMETER VALUE IS NULL");
        }
        $this->params[strtoupper($name)] = $value;
    }

    
    abstract function execute();
//     abstract function outputToCSV();
    
        
    function getResults() {
        return $this->resultSet;
    }
    
    function getFilters() {
        return $this->filters;
    }
    
    
}