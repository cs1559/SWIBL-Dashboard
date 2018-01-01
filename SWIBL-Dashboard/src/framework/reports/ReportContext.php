<?php
namespace Presto\framework\reports;

class ReportContext {
    
    var $params = array();
    
    function addParam($name, $value) {
        $this->params[$name] = $value;
    }
    
    function getParam($name) {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        } else {
            return null;
        }
    } 
    
}

