<?php
namespace Presto\framework\reports;

class ReportException extends \Exception {
    
    function __construct($message="Report Exception", $code="500") {
        parent::__construct($message, $code);
    }
    
}