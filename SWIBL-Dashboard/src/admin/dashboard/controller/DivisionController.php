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
use swibl\client\divisions\DivisionAPI;


/**
 * @author Admin
 *
 */
class DivisionController
{
   protected $container;
   
   public function __construct(Container $container) {
       $this->container = $container;
   }
   
   public function __invoke($request,  $response, $args) {
  
        $svc = DashboardService::getInstance();
        $config = $svc->getConfig();
        $logger=$svc->getLogger();
       
        $season = $config->getPropertyValue("current.season");
       
        $divapi = DivisionAPI::getInstance($svc->getDatabase());
       
        // Instantiate template engine
        try {
            $tdir = __DIR__ . "/../../../../html";
            $templates = new Engine($tdir);
        } catch (\Exception $e) {
            $logger->error($e->getMessage());
            throw new ServiceException($e->getMessage());
        }
        
        try {
            $divisions = $divapi->getDivisionsForSeason($season);
            
            $output =  $templates->render("SetDivisionGames", [
                'divisions' => $divisions
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