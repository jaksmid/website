<?php
     foreach( $this->taskio as $r ):
	if($r['category'] != 'input') continue;
	if($r['type'] == 'Dataset'){
		$dataset = $r['dataset'];
		$dataset_id = $r['value'];
	}
     endforeach; ?>

		<?php if (!isset($this->record['task_id'])){
             echo "Sorry, this task is unknown.";
             die();
    } ?>

		<h1><i class="fa fa-trophy"></i> <?php echo $this->record['type_name']; ?> on <?php echo $dataset; ?></h1>

		<?php if($this->record['type_name'] != 'Learning Curve'){ ?>
		        Show evaluations for score:
				<select class="selectpicker" data-width="auto" onchange="evaluation_measure = this.value; oTableRuns.fnDraw(true); updateTableHeader(); redrawtimechart(); redrawchart();">
					<?php foreach($this->allmeasures as $m): ?>
					<option value="<?php echo $m;?>" <?php echo ($m == $this->current_measure) ? 'selected' : '';?>><?php echo str_replace('_', ' ', $m);?></option>
					<?php endforeach; ?>
				</select>

      <h3>Timeline</h3>

			<div class="col-sm-12 panel reflow-chart" id="data_result_time">Plotting contribution timeline <i class="fa fa-spinner fa-spin"></i></div>

      <h3>Leaderboard</h3>

      <div class='table-responsive panel reflow-table'><table id="leaderboard" class='table table-striped'>
        <thead>
          <tr>
            <th>Rank</th>
            <th>Name</th>
            <th>Top Score</th>
            <th>Entries</th>
            <th>Highest rank</th>
          </tr>
        </thead>
      </table>
      <p>Note: The leaderboard ignores resubmissions of previous solutions</p>
    </div>
<?php } ?>
