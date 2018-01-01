<?php
use Presto\framework\html\Html;

$this->layout('Layout', [
    'title' => 'SWIBL - Administration Dashboard'
]);

?>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?= $this->e($stats->getSeason());?> Season</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $this->e($stats->getTotalTeams());?></div>
                                    <div>Teams</div>
                                </div>
                            </div>
                        </div>
                        <!-- 
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                         -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-calendar fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $this->e($stats->getTotalGamesScheduled());?></div>
                                    <div>Games Scheduled</div>
                                </div>
                            </div>
                        </div>
                        <!--  
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-cubes fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $this->e($stats->getTotalGamesPlayed());?></div>
                                    <div>Games Played</div>
                                </div>
                            </div>
                        </div>
                        <!-- 
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        -->
                    </div>
                </div>
                                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-plus-circle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $this->e($stats->getAverageRunDifferential());?></div>
                                    <div>Average Run Differential</div>
                                </div>
                            </div>
                        </div>
                        <!-- 
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                         -->
                    </div>
            </div>
            <!-- /.row -->
            
        <div class="row">
            <div class="col-lg-6">
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Team Breakdown by Age Group
                        </div>
                        <div class="panel-body">
 							<?= $agechart; ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
            
            
            <div class="col-lg-6">
                     <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Team By Season
                        </div>
                        <div class="panel-body">
 							<?= $chart2; ?>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                    
          
         	</div>
         	<!-- /.row -->

 
        <div class="row">
            <div class="col-lg-6">
                     <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Team Breakdown by Age Group
                        </div>
                        <div class="panel-body">
    						<table style="width: 100%">
    							<thead>
    								<tr>
    									<td><strong>Division Name</strong></td>
    									<td><strong>Total # of Teams</strong></td>
    									<td><strong>Avg Run Diff</strong></td>
    								</tr>
    							</thead>
    							<tbody>
						<?php 
						  foreach ($divisions as $division) {
						      ?>
						      <tr>
						      	<td><?= $division->divisionname?></td>
					            <td><?= $division->number_of_teams?> </td>
					            <td><?= $division->average_run_differential ?></td>
							  </tr>
							  <?php 						      
						  }
						?>
    							</tbody>
    						</table>
						</div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                    
          
         	</div>
         	<!-- /.row -->




