<?php 
    $base_url = "/admin/dashboard";
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$this->e($title)?></title>

	<link rel="shortcut icon" href="<?= $base_url; ?>/html/favicon.ico" type="image/x-icon">
   
     <!-- Bootstrap Core CSS -->
   <!--  <link href="<?= $base_url; ?>/html/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">   -->
   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <!--  <link href="<?= $base_url; ?>/html/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">   -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.2/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?= $base_url; ?>/html/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= $base_url; ?>/html/css/sb-admin-2.css" rel="stylesheet">
    <link href="<?= $base_url; ?>/html/css/dashboard.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <!-- <link href="<?= $base_url; ?>/html/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>  
    
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= $base_url; ?>/">SWIBL - Admin Dashboard</a>
            </div>
            <!-- /.navbar-header -->

             <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="<?= $base_url; ?>"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?= $base_url; ?>/reports/ListDivisionsBySeason">List Divisions by Season</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/LeagueVenueList">League Venues</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/InvalidRosterReport">Roster Analysis Report</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/DoubleRosterReport">Double Roster Report</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/ReportUnavailable">Teams with NO OWNER (Future)</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/ReportUnavailable">Teams with Incorrect # of games scheduled (Future)</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Admin Tasks<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?= $base_url; ?>/SetDivisionGames">Set Division Games</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/ReportUnavailable">Clear CACHE (Future)</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/ReportUnavailable">Add new VENUE (Future)</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/OperationUnavailable">Copy Teams Record History (Future)</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/OperationUnavailable">Change Team Name (Future)</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/OperationUnavailable">Re-calculate Standings (Future)</a>
                                </li>
                                <li>
                                    <a href="<?= $base_url; ?>/reports/OperationUnavailable">Close Season (Future)</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                         <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Mailing Lists<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Create MailChimp Import File<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?= $base_url; ?>/reports/download/MailChimpList?list=coaches">Coaches List</a>
                                        </li>
                                        <li>
                                            <a href="<?= $base_url; ?>/reports/download/MailChimpList?list=parents">Parents List</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>

                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?= $base_url; ?>/reports/OperationUnavailable"><i class="fa fa-table fa-fw"></i>Registration</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        
        <div id="page-wrapper">
            <div>
            <?=$this->section('content')?>
            </div>

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    
    <!-- jQuery -->
   <!--  <script src="<?= $base_url; ?>/html/bower_components/jquery/dist/jquery.min.js"></script>   -->
	<script
			  src="https://code.jquery.com/jquery-2.2.4.min.js"
			  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
			  crossorigin="anonymous"></script>
			  
    <!-- Bootstrap Core JavaScript -->
    <!-- <script src="<?= $base_url; ?>/html/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <!--  <script src="<?= $base_url; ?>/html/bower_components/metisMenu/dist/metisMenu.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.2/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <!-- <script src="<?= $base_url; ?>/html/js/sb-admin-2.js"></script>   -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/2.7.2/metisMenu.min.js"></script>

</body>
</html>
