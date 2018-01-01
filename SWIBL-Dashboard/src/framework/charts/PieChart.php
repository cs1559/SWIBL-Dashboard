<?php
namespace Presto\framework\charts;

class PieChart extends Chart {
    
    function __construct() {
        parent::__construct();
        $this->setTemplate("piechart.html");
    }
}