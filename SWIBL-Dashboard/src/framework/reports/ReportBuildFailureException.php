<?php
namespace Presto\framework\reports;

class ReportBuildFailureException extends ReportException {
    
    function __construct($message="Report Build Failure", $code="500") {
        parent::__construct($message, $code);
    }
    
}