<?php
namespace swibl\admin\dashboard;

use Presto\framework\services\BaseService;
use Presto\framework\database\Database;
use Presto\framework\exception\ConfigurationFileNotFoundException;
use Presto\framework\logger\FileLogger;
use Presto\framework\core\Config;

// use swibl\core\email\Mailer;

/*
 * Copyright 2017 Chris Strieter
 * Licensed under MIT
 */

/**
 * Dashbaord is an service instance that provices access to specific application configuration settings.
 *
 * @author Admin
 *
 */
class DashboardService extends BaseService 
{
    
    private function __construct() {  }
    
    static function getInstance($fdir = null) {
        static $instance;
        if (!is_object( $instance )) {
            $instance = new self();
            $instance->init($fdir);
        }
        return $instance;
    }
    
    /**
     * Initialize the serivce/application.
     *
     * {@inheritDoc}
     */
    public function init($fdir = null)
    {

        // Read the configuration file
        try {
            $fn = $fdir . "config.ini";
            $ini = parse_ini_file($fdir . 'config.ini');
        } catch (\Exception $e) {
            throw new ConfigurationFileNotFoundException();
        }
        $this->setName($ini["service.name"]);
        $this->setVersion($ini["service.build.major"] . "." . $ini["service.build.minor"] . "." . $ini["service.build.patch"]);
        
        $config = new Config();
        foreach ($ini as $name => $value) {
            $config->addProperty($name, $value);
        }
        $this->setConfig($config);
        
        // Establish database connection
        $parms = array();
        $parms["driver"] = $ini["driver"];
        $parms["host"] = $ini["host"];
        $parms["database"] = $ini["database"];
        $parms["user"] = $ini["user"];
        $parms["password"] = $ini["password"];
        $db = & Database::getInstance($parms);
        $this->setDatabase($db);
        
        // Create the logger
        $logfile = $config->getPropertyValue("log.file");
        $logger = FileLogger::getInstance($logfile);
        $logger->setLevel($config->getPropertyValue("log.level"));
        $logger->setEnabled($config->getPropertyValue("log.enabled"));
        $this->setLogger($logger);
        
        $logger->info("Service: " . $this->getName() . " Version: " . $this->getVersion() . " Initialized");
        
        // Create mailer
//         $mailer = new Mailer($config->getPropertyValue("email.fromEmail"),
//             $config->getPropertyValue("email.fromName"));
//         $this->setMailer($mailer);
        
    }
    
}
