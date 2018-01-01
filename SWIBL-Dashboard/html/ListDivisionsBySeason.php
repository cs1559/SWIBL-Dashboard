<?php
use swibl\admin\reports\ReportFilterHelper;

$this->layout('Layout', [
    'title' => 'SWIBL - List Divisions By Season'
]);

?>
		<div id="report-filters"> 
            <div class="row">
				<div class="form-group col-lg-12">
                    <span class="pull-right report-filter-item">
                         <?php echo ReportFilterHelper::getBootstrapSeasonDropdown("seasonid", $filters["seasonid"],"Select Season"); ?>
                    </span>
                </div>
                <!-- /.col-lg-12 -->
            </div>
         </div>
         <div id="report-wrapper">
		<div id="report-content"> 
            <div class="col-lg-12 text-center">
                  <span class="report-title">Divisional Stats for the <?= $data[0]->season ?> Season</span>
			</div>
            <div class="row">
					<table class="table table-striped table-hover">
						<thead class="thead-dark">
							<tr>
								<th><strong>Division Name</strong></th>
								<th class="text-center"><strong>Total # of Teams</strong></th>
								<th class="text-center"><strong>Games Scheduled</strong></th>
								<th class="text-center"><strong>Games Played</strong></th>
								<th class="text-center"><strong>Avg Run Diff</strong></th>
								<th class="text-center"><strong>Total Players</strong></th>
								<th class="text-center"><strong>Avg Roster Size</strong></th>
							</tr>
						</thead>
							<tbody>
				<?php 
				    foreach ($data as $d) {
				?>   
						      <tr>
						      	<td><?= $d->divisionname?></td>
					            <td class="text-center"><?= $d->number_of_teams?> </td>
					            <td class="text-center"><?= $d->number_of_games_scheduled ?></td>
					            <td class="text-center"><?= $d->number_of_games_played ?></td>
					            <td class="text-center"><?= $d->average_run_differential ?></td>
					            <td class="text-center"><?= $d->total_players ?></td>
					            <td class="text-center"><?= $d->average_roster_size ?></td>
							  </tr>
            	<?php 
				    }
            	?>
            					</tbody>
            				</table>
            	</div>
            	<!--  row  -->
		</div>
		<!--  report data -->
         </div>
         
        