<?php
  $nav_selected = "PIPLANNING";
  $left_buttons = "YES";
  $left_selected = "ACTIVE_PI";

  include("./nav.php");
  global $db;

  date_default_timezone_set('America/Chicago');

 ?>

 <div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">PI & I -> Active PI:</h3>

		<table id="info" cellpadding="2px" cellspacing="0" border="0" class="capacity-table"
             width="100%" style="width: 100%; clear: both; font-size: 15px;">

			<thead>
				<tr>
					<th style="text-align:center" colspan="2" id="capacity-table-td">
					<font color="DeepSkyBlue">Current Iteration Details</th>
				</tr>
			</thead>

		  <tbody>

			  <tr>
				<td id='capacity-table-td' style='font-weight:500;'> <b> Today's Date </b></td>
				<?php
					echo "<td id='capacity-table-td' style='font-weight:500;'>" . date("Y-m-d") . "</td>";
				?>
			  </tr>

			  <tr>
				<td id='capacity-table-td' style='font-weight:500;'><b> Program Increment (PI)</b></td>
				<?php
					$sql = "SELECT *
					FROM `cadence`
					WHERE start_date <= '" . date("Y-m-d") . "'
					AND end_date >= '". date("Y-m-d") . "'";
					$result = $db->query($sql);

					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo "<td id='capacity-table-td' style='font-weight:500;'>" . $row["PI_id"] . "</td>";
					} else {
						echo "<td id='capacity-table-td' style='font-weight:500;'>In-between Program Increments</td>";
					}
					$result->close();
				?>
			  </tr>

			  <tr>
				<td id='capacity-table-td' style='font-weight:500;'><b> Iteration</b></td>
				<?php
					$sql = "SELECT *
					FROM `cadence`
					WHERE start_date <= '" . date("Y-m-d") . "'
					AND end_date >= '". date("Y-m-d") . "'";
					$result = $db->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo "<td id='capacity-table-td' style='font-weight:500;'>" . $row["iteration_id"] . "</td>";
					} else {
						echo "<td id='capacity-table-td' style='font-weight:500;'>In-between Iterations</td>";
					}
					$result->close();
				?>
			  </tr>

			  <tr>
				<td id='capacity-table-td' style='font-weight:500;'><b> Current Iteration Ends On</b></td>
				<?php
					$sql = "SELECT *
					FROM `cadence`
					WHERE start_date <= '" . date("Y-m-d") . "'
					AND end_date >= '". date("Y-m-d") . "'";
					$result = $db->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo "<td id='capacity-table-td' style='font-weight:500;'>" . $row["end_date"];
						$date1 = new DateTime(date("Y-m-d"));
						$date2 = new DateTime($row["end_date"]);
						$interval = $date1->diff($date2);
						echo " (In " . ($interval->days) . " days)";
					} else {
						echo "<td id='capacity-table-td' style='font-weight:500;'>In-between Iterations</td>";
					}
					$result->close();
				?>
			  </tr>

			  <tr>
				<td id='capacity-table-td' style='font-weight:500;'><b> Current Program Increment (PI) Ends On </b></td>
				<?php
					$sql = "SELECT *
						FROM
						(	SELECT MIN(start_date) as start_date, MAX(end_date) as end_date
							FROM cadence
							WHERE start_date <= '" . date("Y-m-d") . "'
							OR end_date >= '" . date("Y-m-d") . "'
							GROUP BY PI_ID
						) as PI
						WHERE PI.start_date <= '" . date("Y-m-d") . "'
						AND PI.end_date >= '" . date("Y-m-d") . "'";

					$result = $db->query($sql);

					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo "<td id='capacity-table-td' style='font-weight:500;'>" . $row["end_date"];
						$date1 = new DateTime(date("Y-m-d"));
						$date2 = new DateTime($row["end_date"]);
						$interval = $date1->diff($date2);
						echo " (In " . ($interval->days + 1). " days)";
					} else {
						echo "<td id='capacity-table-td' style='font-weight:500;'>In-between Program Increments</td>";
					}
					$result->close();
				?>

			</tbody>
			<tfoot>
			</tfoot>
		</table>
    </div>
</div>

<?php include("./footer.php"); ?>
