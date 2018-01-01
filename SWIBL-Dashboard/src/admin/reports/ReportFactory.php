<?php
namespace swibl\admin\reports;

use Exception;
use Presto\framework\reports\ReportContext;
use Presto\framework\reports\ReportException;

class ReportFactory {
    
    static function createReport($reportName, ReportContext $context) {
        try {
            switch ($reportName) {
                case "ListDivisionsBySeason":
                    $report = new ListDivisionsBySeason($context);
                    return $report;
                case "LeagueVenueList":
                    $report = new LeagueVenueList($context);
                    return $report;
                case "InvalidRosterReport":
                    $report = new InvalidRosterReport($context);
                    return $report;
                case "DoubleRosterReport":
                    $report = new DoubleRosterReport($context);
                    return $report;
                case "MailChimpList":
                    $report = new MailChimpList($context);
                     return $report;
                default:
                    throw new ReportException("Report Unavailable");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}