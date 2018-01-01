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
    			<span class="report-title">League Venue List</span>
    		</div>
		</div>
		<div class="row">
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th><strong>Venue Name</strong></th>
						<th><strong>Address</strong></th>
						<th><strong>City</strong></th>
						<th><strong>State</strong></th>
						<th><strong>Latitude</strong></th>
						<th><strong>Longitude</strong></th>
					</tr>
				</thead>
				<tbody>
				<?php
    foreach ($data as $d) {
        ?>   
						      <tr>
						<td><?= $d->name ?></td>
						<td><?= $d->address1 ?> </td>
						<td><?= $d->city ?></td>
						<td><?= $d->state ?></td>
						<td><?= $d->latitude ?></td>
						<td><?= $d->longitude ?></td>
 					</tr>
            	<?php 
				    }
            	?>
            					</tbody>
			</table>
		</div>
		<!--  row  -->
	</div>
	<!--  report content -->
</div>
<!--  report wrapper -->       
        