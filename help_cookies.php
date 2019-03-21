<?php

  $nav_selected = "HELP";
  $left_buttons = "YES";
  $left_selected = "LACE_AGENDA";

  include("./nav.php");
  global $db;

  ?>


  <div class="right-content">
   <div class="container">

        <br/><br/>
         <label><b>Select Agile Release Train</b></label>
         <select id='artList' name='artList'>
           <option value="ALL">ALL</option>

           <?php
           $sql = "SELECT team_id, team_name
                  FROM trains_and_teams
                  WHERE type = 'ART'
                  GROUP BY team_name
                  ORDER BY team_name ASC;";

           $result = $db->query($sql);

           if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo"<option value=".urlencode($row['team_id']).">".$row['team_name']."</option>";
              }
           }
           ?>

         </select>

        <br/><br/>

         <label><b>Select Agile Team</b></label>
         <select id='atList' name='atList'>
           <option value="ALL">ALL</option>

           <?php
           $sql = "SELECT team_id, team_name
                  FROM trains_and_teams
                  WHERE type = 'AT'
                  GROUP BY team_name
                  ORDER BY team_name ASC;";

           $result = $db->query($sql);

           if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo"<option value=".urlencode($row['team_id']).">".$row['team_name']."</option>";
              }
           }
           ?>

         </select>

         <br/><br/>

         <input type="button" class="action" onclick="saveListValues();" value="Save" />

         <div id="message">
         </div>

        <script>
        function saveListValues(){
        	var dd = document.getElementById("artList");
        	var filter = dd.options[dd.selectedIndex].value
          if (filter == 'ALL'){
            deleteCookie('art');
          } else {
            setCookie('art', filter, 7);
          }

        	dd = document.getElementById("atList");
        	filter = dd.options[dd.selectedIndex].value
          if (filter == 'ALL'){
            deleteCookie('at');
          } else {
            setCookie('at', filter, 7);
          }

          var div = document.getElementById('message');
          div.innerHTML = '<br/><br/>Preferences saved!';

        }

         function getCookie(name) {
             var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
             return v ? v[2] : 'ALL';
         }

         function setCookie(name, value, days) {
             var d = new Date;
             d.setTime(d.getTime() + 24*60*60*1000*days);
             document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
         }

         function deleteCookie(name) {
           setCookie(name, '', -1);
         }


          $('#atList').val(getCookie('at')).change();
          $('#artList').val(getCookie('art')).change();


       </script>


<?php include("./footer.php"); ?>
