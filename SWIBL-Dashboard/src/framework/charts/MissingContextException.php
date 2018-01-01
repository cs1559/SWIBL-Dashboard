<?php
namespace Presto\framework\charts;

class MissingContextException extends \Exception {
    function __construct($message="Missing Context", $code="500") {
        parent::__construct($message, $code);
    }
}