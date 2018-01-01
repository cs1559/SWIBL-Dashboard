<?php
use Presto\framework\html\Html;

$this->layout('Layout', [
    'title' => 'SWIBL - List Divisions By Season'
]);

?>
		<div id="report-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Mail Chimp Import List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
            	<div id="report_data">
    						<table class="table table-striped table-hover">
    							<thead class="thead-dark">
    								<tr>
    									<th><strong>Email</strong></th>
    									<th ><strong>First Name</strong></th>
    									<th ><strong>Last Name</strong></th>
    									<th ><strong>Phone</strong></th>
    									<th ><strong>City</strong></th>
    									<th ><strong>State</strong></th>
    								</tr>
    							</thead>
    							<tbody>
				<?php 
				    foreach ($data as $d) {
				?>   
						      <tr>
						      	<td><?= $d->email?></td>
					            <td ><?= $d->fname?> </td>
					            <td ><?= $d->lname ?></td>
					            <td ><?= $d->phone ?></td>
					            <td ><?= $d->city ?></td>
					            <td ><?= $d->state ?></td>
							  </tr>
            	<?php 
				    }
            	?>
            					</tbody>
            				</table>
            	</div>
            </div>
		</div>