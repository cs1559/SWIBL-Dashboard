<?php
namespace Presto\framework\services;

use Presto\framework\core\Config;
use Presto\framework\database\Database;
use Presto\framework\logger\Logger;

/*
 MIT License
 
 Copyright (c) 2017 Chris Strieter
 
 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:
 
 The above copyright notice and this permission notice shall be included in all
 copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 SOFTWARE.
 */


/**
 * This is an abstract "application" class that defines the required functions that need to be implemented
 * by the concrete implentations.  The application class will source the name/version of the service or application,
 * return the configuration, logger and the database associated with application.
 * 
 * @author Admin
 *
 */
abstract class BaseService {
    
    private $version = null;
    private $name = null;
    
    private $config = null;
    private $database = null;
    private $logger = null;
    private $mailer = null;
    
    /**
     * @param Config $config
     */
    protected function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param Logger $logger
     */
    protected function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param field_type $mailer
     */
    protected function setMailer($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    abstract public function init();

    /**
     * REturn the Version  of the service.
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }
    
    /**
     * Sets the database object used by objects to retreive game data.
     * @param Database $db
     */
    protected function setDatabase(Database $db) {
        $this->database = $db;
    }
    /*
     * REturns a database instance for this service.
     * @return Database
     */
    public function getDatabase()
    {
        return $this->database;
    }
    
    /*
     * REturn the name of the Service.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * REturns an instance of the configuration
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
    /*
     * REturns the logger for the service.
     * @return FileLogger
     * */
    public function getLogger()
    {
        return $this->logger;
    }
    
    /**
     * Method to indicate if logging is on for the service.
     * @return boolean
     */
    public function isLogEnabled() {
        $config = $this->config;
        return $config->getPropertyValue("log.enabled");
    }
    
    /**
     * Method to indicate if logging is on for the service.
     * @return boolean
     */
    public function isDebugEnabled() {
        $config = $this->config;
        return $config->getPropertyValue("debug.enabled");
    }
    
    /**
     * Method to indicate if mail is enabled for the service.
     * @return boolean
     */
    public function isMailEnabled() {
        $config = $this->config;
        return $config->getPropertyValue("email.enabled");
    }
    
    /**
     * Method to indicate if API authentication is enabled for this service.
     */
    public function isAuthenticationEnabled() {
        $config = $this->config;
        return $config->getPropertyValue("authentication.enabled");
    }
    
    
    public function getMailer()
    {
        return $this->mailer;
    }
    
    
    
}