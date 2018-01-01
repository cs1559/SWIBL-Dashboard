#SWIBL-Dashboard
The SWIBL Dashboard is an administrative dashboard and reporting tool use to administer the sports league.

##Introduction

The SWIBL Dashboard is module is that tracks statistics thoughout the current season.  This may include number of games 
played, number of teams, games scheduled, etc.  It also sources the average run differential which is used to guage how 
well the teams/divisions have been assigned.  

In addition, the dashboard provides administrative reporting capabilities to support the League administration.  The reports 
continually expand as required.  

##Release History


##Database Information

##Configuration

#####Database
* driver = "MySQL"
* host = "localhost"
* database = "swibl_dashboard"
* user = "{dbuser}"
* password = "{dbpassword}"

#####Log
[log]
log.enabled=1
log.file="DashboardService.log"
log.level=3


* current.season [Season] = Numeric value representing the current season id

##Dependencies

* SLIM - slim/slim 3.9
* Guzzle - guzzlehttp/guzzle 6
* Plates - league/plates 3.3
* Charts.JS 2.6 (via CDN)
* FontAwesome (via CDN)
* JQuery (via CDN)

##Deployment

##About



