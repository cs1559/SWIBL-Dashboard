<?php 
namespace swibl\admin\dashboard\controller;

/*
 * swibl\oauth2\HomeController
 * Copyright 2017 Chris Strieter
 * Licensed under MIT 
 */

use Slim\Container;
use Exception;
use swibl\admin\dashboard\DashboardService;
use League\Plates\Engine;
use Presto\framework\services\ServiceException;
use swibl\admin\dashboard\DashboardStatsDAO;
use swibl\admin\reports\ListDivisionsBySeason;
use swibl\admin\reports\MailChimpList;
use swibl\admin\reports\ReportGenerator;
use swibl\admin\reports\ReportFactory;
use Presto\framework\reports\CSVReportInterface;
use Presto\framework\reports\ReportContext;


/**
 * @author Admin
 *
 */
class ReportsController
{
   protected $container;
   
   public function __construct(Container $container) {
       $this->container = $container;
   }
   
   public function __invoke($request,  $response, $args) {
  
       $svc = DashboardService::getInstance();
       $config = $svc->getConfig();
       $logger=$svc->getLogger();
       
//        $homeUrl = (string)($request->getUri()->withPath('')->withQuery('')->withFragment(''));
       
       $reportName = $request->getAttribute("reportName");
       
        $logger->info("Processing request for REPORT " . $reportName);
       
       
        try {
            $tdir = __DIR__ . "/../../../../html";
            $templates = new Engine($tdir);
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            throw new ServiceException($e->getMessage());           
        }
        
        $context = new ReportContext();
        $context->addParam("seasonid", $config->getPropertyValue("current.season"));
        
        foreach ($_REQUEST as $name => $value) {
            $context->addParam($name, $value);
        }
        
        try {
            $logger->debug("creating report " . $reportName);
            $report = ReportFactory::createReport($reportName, $context);
            
            $resultSet = $report->getResults();
            
            $output =  $templates->render($reportName, [
                'data' => $resultSet,
                'filters' => $report->getFilters()
            ]);
        } catch (Exception $e) {
            $logger->error($e->getMessage());
            $output = $templates->render("OperationUnavailable", ['error'=>$e]);
        }
       
       echo $output;
       return $response->withStatus(200)->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
?>