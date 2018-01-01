<?php
namespace Presto\framework\charts;
/*
 * Data
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */

/**
 * This class represents a collection of datasets that are used to generate a chart.
 * @author Admin
 *
 */
class Data {
    
    var $labels = array();
    var $datasets = array();
    
    function addLabel($label) {
        $this->labels[] = $label;
    }
    
    function getLabels() {
        return $this->labels;
    }
    function addDatasets(DataSet $ds) {
        $this->datasets[] = $ds;
    }
    /**
     * @return array DataSet
     */
    function getDatasets() {
        return $this->datasets;
    }
    
}