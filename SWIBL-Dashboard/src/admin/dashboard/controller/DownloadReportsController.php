<?php 
namespace swibl\admin\dashboard\controller;

/*
 * swibl\oauth2\HomeController
 * Copyright 2017 Chris Strieter
 * Licensed under MIT 
 */

use Slim\Container;
use swibl\admin\dashboard\DashboardService;
use swibl\admin\reports\ReportFactory;
use Presto\framework\reports\ReportContext;
use Presto\framework\reports\CSVReportInterface;


/**
 * @author Admin
 *
 */
class DownloadReportsController
{
   protected $container;
   
   public function __construct(Container $container) {
       $this->container = $container;
   }
   
   public function __invoke($request,  $response, $args) {
  
       $svc = DashboardService::getInstance();
       $config = $svc->getConfig();
       $logger=$svc->getLogger();
       
       
       $reportName = $request->getAttribute("reportName");
       
       // Set Default Season
      
       $context = new ReportContext();
       $context->addParam("seasonid", $config->getPropertyValue("current.season"));
       foreach ($_REQUEST as $name => $value) {
           $context->addParam($name, $value);
       }
       
       $report = ReportFactory::createReport($reportName, $context);
       
       if ($report instanceOf CSVReportInterface) {
           $output = $report->outputToCSV();  
           $response->write($output);
           return $response->withHeader('Content-Type','text/csv')->withHeader('Content-Disposition', 'attachment; filename=' . $reportName . '.csv');
       } else {
           echo "Report is not able to be downloaded in CSV format";
           return $response->withStatus(200)->withHeader('Content-Type', 'text/html; charset=UTF-8');
       }

       


    }
}
?>