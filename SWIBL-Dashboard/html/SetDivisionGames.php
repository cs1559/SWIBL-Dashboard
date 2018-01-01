<?php
use swibl\admin\reports\ReportFilterHelper;

$this->layout('Layout', [
    'title' => 'SWIBL - Set Division Games'
]);

?>

		<div class="row">
    		<div class="col-lg-12 text-center">
    			<span class="report-title">Set Division Games</span>
    		</div>
		</div>
		<div class="row ">
					<form >
			<div class="col-lg-12 text-center"></div>

			<table>
        <?php 
            foreach ($divisions as $d) {
                if (!$d->isParent()) {
        ?>
        	<tr>
				<td>
        		<label for="input-div<?= $d->id?>"><?=$d->name ?></label>
        		</td>
        		<td>
        		<input type="text" class="form-control" id="input-div<?= $d->id?>" required>
        		</td> 
        	</div>
        	</tr>
        <?php
                }
            }
        ?>
        		</table>
	        	</div>
        	</form>

		</div>
		
		
		

		