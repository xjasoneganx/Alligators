<?php

// if( !function_exists('apache_request_headers') ) {

//   function apache_request_headers() {
//       $arh = array();
//       $rx_http = '/AHTTP_/';
//       foreach($_SERVER as $key => $val) {
//           if( preg_match($rx_http, $key) ) {
//               $arh_key = preg_replace($rx_http, '', $key);
//               $rx_matches = array();
//
//               $rx_matches = explode('_', $arh_key);
//               if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
//                   foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
//                   $arh_key = implode('-', $rx_matches);
//               }
//               $arh[$arh_key] = $val;
//           }
//       }
//       return( $arh );
//   }
// }
// $headers = apache_request_headers();
//
// if (!isset($headers['AUTHORIZATION']) || substr($headers['AUTHORIZATION'],0,4) !== 'NTLM'){
//       header('HTTP/1.1 401 Unauthorized');
//       header('WWW-Authenticate: NTLM');
//       exit;
// }
//
// $auth = $headers['AUTHORIZATION'];
//
// if (substr($auth,0,5) == 'NTLM ') {
//         $msg = base64_decode(substr($auth, 5));
//         if (substr($msg, 0, 8) != "NTLMSSPx00")
//                 die('error header not recognised');
//
//         if ($msg[8] == "x01") {
//                 $msg2 = "NTLMSSPx00x02"."x00x00x00x00".
//                         "x00x00x00x00".
//                         "x01x02x81x01".
//                         "x00x00x00x00x00x00x00x00".
//                         "x00x00x00x00x00x00x00x00".
//                         "x00x00x00x00x30x00x00x00";
//
//                 header('HTTP/1.1 401 Unauthorized');
//                 header('WWW-Authenticate: NTLM '.trim(base64_encode($msg2)));
//                 exit;
//         }
//         else if ($msg[8] == "x03") {
//                 function get_msg_str($msg, $start, $unicode = true) {
//                         $len = (ord($msg[$start+1]) * 256) + ord($msg[$start]);
//                         $off = (ord($msg[$start+5]) * 256) + ord($msg[$start+4]);
//                         if ($unicode)
//                                 return str_replace("\0", '', substr($msg, $off, $len));
//                         else
//                                 return substr($msg, $off, $len);
//                 }
//                 $user = get_msg_str($msg, 36);
//                 $domain = get_msg_str($msg, 28);
//                 $workstation = get_msg_str($msg, 44);
//                 print "You are $user from $workstation.$domain";
//         }
// }


  $nav_selected = "PIPLANNING";
  $left_buttons = "YES";
  $left_selected = "CADENCE";

  include("./nav.php");
  global $db;

  $hostname = gethostname();

  $image = "";

  //Amanda: svi6w289
  //Jasthi: svi6p274

  if($hostname == 'svi6p274' || $hostname == 'ami6p042' || $hostname == 'cii6p660'){
    $image = "<img src='images/edit.png' align='right' style='max-height: 15px;'/>";
  }
?>


  <div class="right-content">
   <div class="container">

       <h3 style = "color: #01B0F1;">PI & I -> Cadence:</h3>

        <table id="info" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered datatable-style"
              width="100%" style="width: 100px;">
              <thead>
                <tr id="table-first-row">
                  <th>Sequence</th>
                  <th>Program Increment</th>
                  <th>Iteration</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Duration</th>
                  <th>SAFe Comments</th>
                  <th>Release Overlay</th>
                  <th>Comments</th>
                </tr>
              </thead>

              <tbody>

                <?php

                 $sql = "select *
                         from cadence";
                 $result = $db->query($sql);

                 if($result -> num_rows > 0){
                   while($row = $result -> fetch_assoc()){


					if ($row["comments"] == "null"){
						$comments = "-";
					} else {
						$comments = $row["comments"];
					}

                     echo
                     "<tr>
                         <td >" . $row["sequence"] . "</td>
                         <td>" .$row["PI_id"] ."</td>
                         <td>" .$row["iteration_id"] . "</td>
                          <td>" .$row["start_date"] ."</td>
                         <td>" .$row["end_date"] ."</td>
                         <td>" .$row["duration"] ."</td>
                         <td>" .$row["safe_comments"] .$image."</td>
                         <td>" .$row["release_overlay"].$image."</td>
                         <td>" .$row["comments"].$image."</td>
                       </tr>";
                   }

                 }
                  else {
                   echo "0 results";
                 }

                 $result->close();
                ?>

              </tbody>
        </table>


        <script type="text/javascript">

         $(document).ready(function () {

             $('#info').DataTable({

             });

         });

     </script>

  <?php include("./footer.php"); ?>
