<?php
namespace Presto\framework\charts;

/*
 * HomeController
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */

class ChartRenderer {
    
    var $strategy;
    
    function __construct($impl) {
        switch ($impl) {
            case "Chart.js":
                $this->strategy = new ChartJSRenderer();
        }
    }
    
    function render(Chart $chart) {
       return $this->strategy->renderChart($chart);
    }
    
}