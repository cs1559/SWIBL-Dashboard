<?php
namespace Presto\framework\charts;

class DataUnavailableException extends \Exception {
    function __construct($message="Data Unavailable", $code="500") {
        parent::__construct($message, $code);
    }
}