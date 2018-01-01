<?php 
namespace swibl\admin\dashboard\controller;

/*
 * HomeController
 * Copyright 2017 Chris Strieter
 * Licensed under MIT 
 */

use Presto\framework\charts\ChartRenderer;
use Slim\Container;
use swibl\admin\dashboard\DashboardService;
use League\Plates\Engine;
use Presto\framework\services\ServiceException;
use swibl\admin\dashboard\DashboardStatsDAO;
use swibl\admin\reports\ListDivisionsBySeason;

use swibl\admin\dashboard\widgets\TeamsByAgeGroupPieChart;
use Presto\framework\reports\ReportContext;
use swibl\admin\dashboard\widgets\TeamsByYearLineChart;


/**
 * @author Admin
 *
 */
class HomeController
{
   protected $container;
   
   public function __construct(Container $container) {
       $this->container = $container;
   }
   
   public function __invoke($request,  $response, $args) {
  
       $svc = DashboardService::getInstance();
       $config = $svc->getConfig();
       $logger=$svc->getLogger();
       
       $homeUrl = (string)($request->getUri()->withPath('')->withQuery('')->withFragment(''));
       
       $season = $config->getPropertyValue("current.season");
       $logger->info("Season= " . $season);
       
        // $tdir = __DIR__ . "\\..\\templates";
       try {
            $tdir = __DIR__ . "/../../../../html";
            $templates = new Engine($tdir);
       } catch (\Exception $e) {
            $logger->error($e->getMessage());
           throw new ServiceException($e->getMessage());           
       }

       $logger->debug("retrieving DAO object");
       $dao = DashboardStatsDAO::getInstance($svc->getDatabase());
       $logger->debug("getting stats");
       try {
           $stats = $dao->getSeasonStatistics($season);
            
           $teamsbyage = $dao->getTeamCountsByAgeGroup($season);
           $logger->debug("Team Counts by age group retrieved");
       } catch (\Exception $e) {
           echo $e->getMessage();
           throw $e;
       }
       
       $context = new ReportContext();
       $context->addParam("seasonid", $season);
       $rpt1 = new ListDivisionsBySeason($context);
       $rpt1->execute();
       $divisions = $rpt1->getResults();
       
       $agechart = new TeamsByAgeGroupPieChart($season);
       $linechart = new TeamsByYearLineChart($season);
       $renderer = new ChartRenderer("Chart.js");
       
       $chartHtml = $renderer->render($agechart);
       $lineChartHtml = $renderer->render($linechart);
       echo $templates->render('Home', [
           'stats' => $stats,
           'divisions' => $divisions,
           'agechart' => $chartHtml,
           'chart2' => $lineChartHtml
       ]);
        
       return $response->withStatus(200)->withHeader('Content-Type', 'text/html; charset=UTF-8');
    }
}
?>