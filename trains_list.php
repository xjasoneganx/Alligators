<?php

  $nav_selected = "TRAINS";
  $left_buttons = "YES";
  $left_selected = "LIST";

  include("./nav.php");
  global $db;

  ?>

<div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">Trains -> List:</h3>

        <h3><img src="images/solution_train.png" style="max-height: 35px;" /> Solution Trains (ST),
            <img src="images/agile_release_train.png" style="max-height: 35px;" />Agile Release Trains (ART),
            <img src="images/agile_team.png" style="max-height: 35px;" />Agile Teams (AT)</h3>

        <table id="info" cellpadding="0" cellspacing="0" border="0"
               class="datatable table table-striped table-bordered datatable-style table-hover"
               width="100%" style="width: 100px;">

            <thead>

            <tr id="table-first-row">

                <th>Team Name</th>
                <th>Type</th>
                <th>Scrum Master / RTE / STE</th>
                <th>PM / PO</th>
                <th>Architect</th>
                <th>Parent Name</th>

            </tr>

            </thead>

            <tfoot>
              <tr>
              <th>Team Name</th>
              <th>Type</th>
              <th>Scrum Master / RTE / STE</th>
              <th>PM / PO</th>
              <th>Architect</th>
              <th>Parent Name</th>
            </tr>
            </tfoot>

            <tbody>


            <?php

            $sql = "SELECT tt.type, tt.team_name,
            MAX(CASE WHEN (membership.role = 'Scrum Master' OR membership.role = 'Release Train Engineer'
              OR membership.role = 'Solution Train Engineer') THEN membership.employee_name ELSE NULL END) AS SSM_RTE_STE,
            MAX(CASE WHEN (membership.role = 'Product Manager' OR membership.role = 'Product Owner') THEN membership.employee_name ELSE NULL END) AS PM_PO,
            MAX(CASE WHEN membership.role = 'Architect' THEN membership.employee_name ELSE NULL END) AS Architect, tt.parent_name
            FROM trains_and_teams tt LEFT JOIN membership ON (tt.team_name = membership.team_name)
            GROUP BY tt.team_name;";

            $result = $db->query($sql);

            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                  $team_name = $row["team_name"];
                  $type = $row["type"];

                  switch ($type){
                    case 'AT':
                    echo "<tr>
                          <td><a href='view_at.php?id=" . $team_name . "'>".$team_name."</a></td>";
                          break;
                    case 'ART':
                    echo "<tr>
                          <td><a href='view_art.php?id=" . $team_name . "'>".$team_name."</a></td>";
                          break;
                    case 'ST':
                    echo "<tr>
                          <td><a href='view_st.php?id=" . $team_name . "'>".$team_name."</a></td>";
                          break;
                  }

                  echo  "<td>" . $type . "</td>
            			      <td>" . $row["SSM_RTE_STE"] . "</td>
                        <td>" . $row["PM_PO"] . "</td>
                        <td>" . $row["Architect"] . "</td>
                        <td>" . $row["parent_name"] . "</td>
                    </tr>";
                }
            } else {
                echo "0 results";
            }

            $result->close();
            ?>

            </tbody>

            <tfoot>

            </tfoot>

        </table>

    </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function () {

            $('#info').DataTable({

              initComplete: function () {
                this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option>'+d+'</option>' )
                } );
            } );
        }

            });

        });

    </script>
<style>
  tfoot {
    display: table-header-group;
  }
</style>

<?php include("./footer.php"); ?>
