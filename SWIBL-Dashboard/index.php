<?php

use swibl\admin\dashboard\controller\DivisionController;
use swibl\admin\dashboard\controller\DownloadReportsController;
use swibl\admin\dashboard\controller\HomeController;
use swibl\admin\dashboard\controller\ReportsController;

/**
 * This is the main contorller for the Dashboard Service.
 */


require 'vendor/autoload.php';

// Bootstrap the service
if (file_exists('bootstrap.php'))
{
    include_once 'bootstrap.php';
}

$c = new \Slim\Container(); //Create Your container

//Override the default Not Found Handler
$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']
        ->withStatus(404)
        ->withHeader('Content-Type', 'text/html')
        ->write('SWIBL API - Page/Route not found');
    };
};
$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $c['response']->withStatus(500)
        ->withHeader('Content-Type', 'text/html')
        ->write($exception->getMessage());
    };
};


$config = [
    'settings' => [
        'displayErrorDetails' => true, 
    ],
];

$app = new \Slim\App($c);
$app->
// $app->add(new OAuthRequestAuthorizer());


$app->get('/', HomeController::class);
$app->get('/SetDivisionGames', DivisionController::class);
$app->get('/reports/{reportName}', ReportsController::class);
$app->get('/reports/download/{reportName}', DownloadReportsController::class);
            
$app->run();
                    
                    
                    