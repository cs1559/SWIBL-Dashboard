<?php
use swibl\admin\reports\ReportFilterHelper;

$this->layout('Layout', [
    'title' => 'SWIBL - Roster Analysis Report'
]);

?>
<div id="report-wrapper">
	<div id="report-content">
		<div class="row">
    		<div class="col-lg-12 text-center">
    			<span class="report-title">Team Roster Analysis Report - <?= $data[0]->season ?> Season</span>
    		</div>
		</div>
		<div class="row">
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th><strong>Team Name</strong></th>
						<th><strong>ID</strong></th>
						<th><strong>Head Coach</strong></th>
						<th><strong>Age Group</strong></th>
						<th><strong>Division</strong></th>
						<th><strong>Players</strong></th>
						<th><strong>Subs</strong></th>
						<th><strong>Issue</strong></th>
					</tr>
				</thead>
				<tbody>
				<?php
    $cnt = 0;
    $tooManyPlayers = 0;
    $tooManyRegulars = 0;
    $tooManySubs = 0;
    $tooFewPlayers = 0;
    $goodrosters = 0;
    $missingRoster = 0;
    
    foreach ($data as $d) {
        $cnt = $cnt + 1;
        $status = "OK";
        $code = 0;
        if (($d->regular + $d->substitute) > 15) {
            $status = "Too many PLAYERS on roster";
            $code = 1;
        }
        if ($d->regular > 12) {
            $status = "Too many REGULAR players on roster";
            $code = 2;
        }
        if ($d->substitute > 3) {
            $status = "Too many SUBSTITUTE players on roster";
            $code = 3;
        }
        if (($d->regular + $d->substitute) < 9) {
            $status = "Too FEW PLAYERS on roster";
            $code = 4;
        }
        if (($d->regular + $d->substitute) == 0) {
            $status = "Missing Roster";
            $code = 5;
        }
        
        switch ($code) {
            case 0:
                $goodrosters = $goodrosters + 1;
                break;
            case 1:
                $tooManyPlayers = $tooManyPlayers + 1;
                break;
            case 2:
                $tooManyRegulars = $tooManyRegulars + 1;
                break;
            case 3:
                $tooManySubs = $tooManySubs + 1;
                break;
            case 4:
                $tooFewPlayers = $tooFewPlayers + 1;
                break;
            case 5:
                $missingRoster = $missingRoster + 1;
                break;
            default:
                $goodrosters = $goodrosters + 1;
                break;
        }

        ?>   
				      <tr>
						<td><?= $d->teamname ?></td>
						<td><?= $d->teamid ?></td>
						<td><?= $d->coachname ?> </td>
						<td><?= $d->agegroup ?></td>
						<td><?= $d->divisionname ?></td>
						<td><?= $d->regular ?></td>
						<td><?= $d->substitute ?></td>
						<td><?= $status ?></td>
 					</tr>
            	<?php 
				    }
            	?>
            					</tbody>
			</table>
			<br>
			<strong>Summary Details</strong><br/>
			Total MISSING ROSTERS: <?= $missingRoster ?><br/>
			Total TOO FEW PLAYERS: <?= $tooFewPlayers ?><br/>
			Total TOO MANY PLAYERS: <?= $tooManyPlayers ?><br/>
			Total TOO MANY REGULARS: <?= $tooManyRegulars ?><br/>
			Total TOO MANY SUBSTITUTES: <?= $tooManySubs ?><br/>
			Total GOOD ROSTERS: <?= $goodrosters ?><br/>
			<br/>
			Total Teams Listed: <?= $cnt; ?><br>
			<br/><br/>
		</div>
		<!--  row  -->
	</div>
	<!--  report content -->
</div>
<!--  report wrapper -->       
        