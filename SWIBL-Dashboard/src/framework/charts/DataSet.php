<?php
namespace Presto\framework\charts;
/*
 * DataSet
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */

/**
 * @author Admin
 *
 */
class DataSet {
    
    var $label;
    var $items = array();
    
    function __construct($label=null) {
        $this->label = $label;
    }
    /**
     * @return string $label
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    public function setLabel($label) {
        $this->label = $label;
    }
    
    public function addDataItem(DataItem $item) {
        $this->items[] = $item;
    }
    
    /**
     * @return unknown
     */
    public function getDataItems() {
        return $this->items;
    }
    
    public function getDataValues() {
        $returnArray = array();
        foreach ($this->items as $item) {
            $returnArray[] = $item->getValue();
        }
        return $returnArray;
    }
    
    public function getBackgroundColors() {
        $returnArray = array();
        foreach ($this->items as $item) {
            $returnArray[] = $item->getBackgroundcolor();
        }
        return $returnArray;
    }
    

}