<?php
namespace framework\reports\formatters;

use Presto\framework\reports\ReportInterface;

interface FormatterInterface
{
    function generate(ReportInterface $report);
}

