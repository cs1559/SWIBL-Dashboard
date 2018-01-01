<?php
namespace Presto\framework\charts;
/*
 * Chart
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */

class Chart {
    
    var $elementId;
    var $data;
    var $template;
    
    /**
     * @return string $elementId
     */
    public function getElementId()
    {
        return $this->elementId;
    }

    /**
     * @return string $template
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $elementId
     */
    public function setElementId($elementId)
    {
        $this->elementId = $elementId;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    function __construct() {
    }
    
//     function render() {
//         $tmpl = __DIR__ . "/piechart-template.html";
//         $myfile = fopen($tmpl, "r") or die("Unable to open file!");
//         $html =  fread($myfile,filesize($tmpl));
//         fclose($myfile);
//         return $html;
//     }
    
    public function setData(Data $data) {
        $this->data = $data;
    }
    
    /**
     * @return \swibl\admin\dashboard\widgets\Data
     */
    public function getData() {
        return $this->data;
    }
//     function __toString() {
//         return htmlspecialchars_decode(self::render());
//     }

}