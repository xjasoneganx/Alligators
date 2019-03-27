<?php

  $nav_selected = "TRAINS";
  $left_buttons = "YES";
  $left_selected = "LISTS";

  include("./nav.php");
  global $db;

  ?>

<div class="right-content">
    <div class="container">

      <h3 style = "color: #01B0F1;">Trains -> Lists:</h3>

        <!--  BEGIN: "Agile Team" -->

       <h3><img src="images/agile_team.png" style="max-height: 35px;" /> Agile Team (AT) </h3>


        <table id="AT" cellpadding="0" cellspacing="0" border="0"
               class="datatable table table-striped table-bordered datatable-style table-hover"
               width="100%" style="width: 100px;">

            <thead>
                <tr id="table-first-row">
                    <th>Name</th>
                    <th>SSM</th>
                    <th>PO</th>
                    <th>Architect</th>
                    <th>Agile Release Train</th>
                </tr>
            </thead>

            <tbody>


            <?php
                    $sql = "SELECT tt.team_name,
                    MAX(CASE WHEN membership.role = 'Scrum Master' THEN membership.employee_name ELSE NULL END) AS SSM,
                    MAX(CASE WHEN membership.role = 'Product Owner' THEN membership.employee_name ELSE NULL END) AS PO,
                    MAX(CASE WHEN membership.role = 'Architect' THEN membership.employee_name ELSE NULL END) AS Architect, tt.parent_name
                    FROM trains_and_teams tt LEFT JOIN membership ON (tt.team_name = membership.team_name)
                    WHERE tt.type = 'AT'
                    GROUP BY tt.team_name;";

                    $result = $db->query($sql);


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $team_name = $row["team_name"];

                          echo
                            "<tr>
                            <td><a href='view_at.php?id=" . $team_name . "'>".$team_name."</a></td>
                                <td>" . $row["SSM"] . "</td>
                                <td>" . $row["PO"] . "</td>
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

        </table>

<!--  END: "Agile Team" -->

<!--  BEGIN: "Agile Release Train" -->

        <h3><img src="images/agile_release_train.png" style="max-height: 35px;" /> Agile Release Trains (ART) </h3>

        <table id="ART" cellpadding="0" cellspacing="0" border="0"
               class="datatable table table-striped table-bordered datatable-style table-hover"
               width="100%" style="width: 100px;">

            <thead>
                <tr id="table-first-row">
                    <th>Name</th>
                    <th>RTE</th>
                    <th>PM</th>
                    <th>Architect</th>
                    <th>Solution Train</th>
                </tr>
            </thead>

            <tbody>


            <?php
                $sql = "SELECT tt.team_name,
                        MAX(CASE WHEN membership.role = 'Release Train Engineer' THEN membership.employee_name ELSE NULL END) AS RTE,
                        MAX(CASE WHEN membership.role = 'Product Manager' THEN membership.employee_name ELSE NULL END) AS PM,
                        MAX(CASE WHEN membership.role = 'Architect' THEN membership.employee_name ELSE NULL END) AS Architect, tt.parent_name
                        FROM trains_and_teams tt LEFT JOIN membership ON (tt.team_name = membership.team_name)
                        WHERE tt.type = 'ART'
                        GROUP BY tt.team_name;";

                    $result = $db->query($sql);


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                          $team_name = $row["team_name"];

                          echo
                            "<tr>
                            <td><a href='view_art.php?id=" . $team_name . "'>".$team_name."</a></td>
                            <td>" . $row["RTE"] . "</td>
                            <td>" . $row["PM"] . "</td>
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

        </table>

<!--  END: "Agile Release Train Train" -->


<!--  BEGIN: "Solution Train" -->

      <h3><img src="images/solution_train.png" style="max-height: 35px;" /> Solution Trains (ST) </h3>

        <table id="ST" cellpadding="0" cellspacing="0" border="0"
               class="datatable table table-striped table-bordered datatable-style table-hover"
               width="100%" style="width: 100px;">

            <thead>
                <tr id="table-first-row">
                    <th>Name</th>
                    <th>STE</th>
                    <th>Solution Manager</th>
                    <th>Enterprise Architect</th>
                </tr>
            </thead>

            <tbody>


            <?php
                      $sql ="SELECT tt.team_name,
                            MAX(CASE WHEN membership.role = 'Solution Train Engineer' THEN membership.employee_name ELSE NULL END) AS STE,
                            MAX(CASE WHEN membership.role = 'Solution Manager' THEN membership.employee_name ELSE NULL END) AS SM,
                            MAX(CASE WHEN membership.role = 'Architect' THEN membership.employee_name ELSE NULL END) AS Architect
                            FROM trains_and_teams tt LEFT JOIN membership ON (tt.team_name = membership.team_name)
                            WHERE tt.type = 'ST'
                            GROUP BY tt.team_name;";

                    $result = $db->query($sql);


                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                          $team_name = $row["team_name"];

                          echo
                            "<tr>
                            <td><a href='view_st.php?id=" . $team_name . "'>".$team_name."</a></td>
                                <td>" . $row["STE"] . "</td>
                                <td>" . $row["SM"] . "</td>
                                <td>" . $row["Architect"] . "</td>

                            </tr>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $result->close();
            ?>

            </tbody>

        </table>

    </div>
</div>
<!--  END: "Solution Train" -->

<script type="text/javascript">
    $(document).ready(function () {
        $('#AT').DataTable();
        $('#ART').DataTable();
        $('#ST').DataTable();
    });
</script>

<?php include("./footer.php"); ?>
