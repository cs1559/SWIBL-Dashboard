<?php
use swibl\admin\reports\ReportFilterHelper;

$this->layout('Layout', [
    'title' => 'SWIBL - League Venues'
]);

?>
<div id="report-wrapper">
	<div id="report-content">
		<div class="row">
    		<div class="col-lg-12 text-center">
    			<span class="report-title">Double Roster Report</span>
    		</div>
		</div>
		<div class="row">
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th><strong>Last Name</strong></th>
						<th><strong>First Name</strong></th>
						<th><strong>Team ID</strong></th>
						<th><strong>Team Name</strong></th>
						<th><strong>Age Group</strong></th>
						<th><strong>Division</strong></th>
						<th><strong>Key</strong></th>
					</tr>
				</thead>
				<tbody>
				<?php
    $cnt = 0;
    foreach ($data as $d) {
        $cnt = $cnt + 1;
        ?>   
				      <tr>
						<td><?= $d->lastname ?></td>
						<td><?= $d->firstname ?> </td>
						<td><?= $d->teamid ?></td>
						<td><?= $d->teamname ?></td>
						<td><?= $d->agegroup ?></td>
						<td><?= $d->divisionname ?></td>
						<td><?= $d->keyfld ?></td>
 					</tr>
            	<?php 
				    }
            	?>
            					</tbody>
			</table>
			<br/>
			Record Count: <?= $cnt; ?>
			<br/><br/>
		</div>
		<!--  row  -->
	</div>
	<!--  report content -->
</div>
<!--  report wrapper -->       
        