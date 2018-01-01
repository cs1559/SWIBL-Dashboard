<?php
namespace Presto\framework\charts;

class LineChart extends Chart {
    function __construct() {
        parent::__construct();
        $this->setTemplate("linechart.html");
    }
}