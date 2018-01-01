<?php
namespace swibl\admin\reports;

class ReportGenerator {

    private $templateDir;
    private $format="html";
    private $context = array();
    
    function __construct($tdir) {
        // Set the primary template directory
        $this->templateDir = $tdir;
        $this->init();
    }
    
    private function init() {
        foreach ($_REQUEST as $key => $value) {
            $this->context[$key] = $value;
        }
    }
    
  
    function generate($reportName) {
        
        print_r($this->context);
        
        // Build Report Object
        // Get Format type
        // Execute to get result set
          
    }
    
}