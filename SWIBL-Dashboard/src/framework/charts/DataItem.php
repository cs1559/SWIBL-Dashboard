<?php
namespace Presto\framework\charts;
/*
 * DataItem
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */

class DataItem {
    
    var $label;
    var $value;
    var $backgroundcolor;
    var $bordercolor;
    
    function __construct($label, $value, $background=null, $border=null) {
        $this->label = $label;
        $this->value = $value;
        $this->backgroundcolor = $background;
        $this->border = $border;
    }
    
    /**
     * @return string $label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string $backgroundcolor
     */
    public function getBackgroundcolor()
    {
        return $this->backgroundcolor;
    }

    /**
     * @return string $bordercolor
     */
    public function getBordercolor()
    {
        return $this->bordercolor;
    }

    
}