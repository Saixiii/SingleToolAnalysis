<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Author" content="Suphakit Annoppornchai">
    <title>MSTM - Single Tool Analysis</title>
    <script type="text/javascript" language="javascript" src="stmenu.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/dateformat.js"></script>
                <script type="text/javascript" charset="utf-8" src="js/jquery-2.1.0.min.js"></script>
                <script type="text/javascript" charset="utf-8" src="jquery-ui-1.11.1/jquery-ui.min.js"></script>
                <script type="text/javascript" charset="utf-8" src="datetimepicker-master/jquery.datetimepicker.js"></script>
                <script type="text/javascript" charset="utf-8" src="animsition-master/dist/js/jquery.animsition.min.js"></script>
                <link rel="icon" type="image/png" href="/sta/images/iservice.png"/>
                <link rel="stylesheet" href="/sta/animsition-master/dist/css/animsition.min.css">
                <style type="text/css" title="currentStyle">
                        @import "css/layout/style.css";
                        @import "jquery-ui-1.11.1/jquery-ui.min.css";
                        @import "datetimepicker-master/jquery.datetimepicker.css";
                </style>

                <script type="text/javascript" charset="utf-8">

                  <?php
                   $key = isset($_GET['input_key']) ? $_GET['input_key'] : '';
                   $start_dt = isset($_GET['input_start_dt']) ? $_GET['input_start_dt'] : '';
                   $end_dt = isset($_GET['input_end_dt']) ? $_GET['input_end_dt'] : '';
                  
                   if(!empty($_POST['key']) && isset($_POST['key'])) {
                        $key = $_POST['key'];
                        $start_dt = $_POST['start_dt'];
                        $end_dt = $_POST['end_dt'];
                   }
                   
                   $inbox_key = $key;
                   if($inbox_key == "") {
                        $inbox_key = '%';
                   }
                   
       putenv("ORACLE_HOME=/usr/lib/oracle/11.2/client64");                
       $dbhost = "localhost"; // DB Host name
       $dbusername = "sta"; // DB User
       $dbpass = "sta"; // DB User password
       $dbname = "sta"; // DB Name
       $query = "select distinct(service_name) from ne";
       $connection = mysql_connect($dbhost, $dbusername, $dbpass);
       $resultmenu1 = mysql_db_query($dbname, $query);
       $numrowsmenu1 = mysql_num_rows($resultmenu1);
      ?>

                        var date = new Date();
                        var today = date.format("yyyymmdd");
                        var start_date = "<?php echo $start_dt; ?>";
                        var end_date = "<?php echo $end_dt; ?>";

                        if(start_date  == "" || end_date == "") {
                                start_date = today + "0000";
                                end_date = today + "2359";
                        }

                        $(document).ready( function () {

                                $(".animsition").animsition({
                                        inClass : 'fade-in',
                                        outClass: 'fade-out',
                                        inDuration:1200,
                                        outDuration :800,
                                        linkElement : 'a:not([href^=#]):not([class="toggle-vis"])',
                                        touchSupport:true,
                                        loading :true,
                                        loadingParentElement: 'body', //animsition wrapper element
                                        loadingClass: 'animsition-loading',
                                        unSupportCss: [ 'animation-duration',
                                        '-webkit-animation-duration',
                                        '-o-animation-duration'
                                        ]
                                });


                          jQuery(function(){
          jQuery('#start_dt').datetimepicker({
                format:'YmdHi',
                value:start_date,
                maxDate:0,
                closeOnDateSelect:true,
          });
          jQuery('#end_dt').datetimepicker({
                format:'YmdHi',
                value:end_date,
                maxDate:0,
                closeOnDateSelect:true     
          });
        });
                        });

                        $(function() {
                                $( document ).tooltip();
                                $( "input[type=submit], button" )
                                .button()
                                .click(function( event ){
                                });
                                $("input:text").addClass("ui-corner-all");

                        });

                        function checkIt(evt) {
                                evt = (evt) ? evt : window.event
                                var charCode = (evt.which) ? evt.which : evt.keyCode
                                if ((charCode > 31 && charCode != 37 && (charCode < 48 || charCode > 57))) {
                                        status = "This field accepts numbers only."
                                        return false
                                }
                                status = ""
                                return true
                        }

      
                </script>
  </head>
  
  
  
  <body>
        <div class="animsition">
        <div class="content">
                <div class="top_tab" >
                  <div style="text-align: center">
                        <a href="/sta"><img src="/sta/images/truemini.png" title="Home Page" style="border-style: none"/></a>
                  </div>
          </div>
                <div class="top_block">
                        <div id="headdetail" class="detail" title="Searching Detail">
                          <?php
                          echo 'Search Key&nbsp&nbsp&nbsp'.$key.'</br>';
                          if($start_dt == "") {
                                echo 'Start Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.'</br>';
                                echo 'End Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.'</br>';
                          } else {
                                echo 'Start Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.substr($start_dt,6,2).' / '.substr($start_dt,4,2).' / '.substr($start_dt,0,4).'&nbsp&nbsp'.substr($start_dt,8,2).':'.substr($start_dt,10,2).'</br>';
                                echo 'End Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'.substr($end_dt,6,2).' / '.substr($end_dt,4,2).' / '.substr($end_dt,0,4).'&nbsp&nbsp'.substr($end_dt,8,2).':'.substr($end_dt,10,2).'</br>';
                          }
                                ?>
                        </div>
      </div>
      
      <div class="center_block">
        <div class="alignleft">
                MSTM - Single Tool Analysis </br>
        </div>
        </br></br>
        <div class="content">
          <?php echo 'Client IP : '.$_SERVER['REMOTE_ADDR'];?>
        </div>
        <div class="hr"><hr/></div>
          <div class="content">
                  <?php
                  if(!empty($_GET['input_ne']) && isset($_GET['input_ne'])) {
                        print "$_GET[input_service]";
                        print " > ";
                        print "$_GET[input_ne]";
                        print " > ";
                        echo "$_GET[input_cmd]";
                  } else {
                        echo "Contact us : MSTM_VAS@truecorp.co.th";
                  }
                  ?>
          </div>
        <div class="hr"><hr/></div>
      </div>
      
      
      <div class="left_block left">
        <form name="input" method="post" action="" target="" style="font-size: 4pt">
          <input id="key" name="key" type="text" size="13" style="font-size: 11px" onKeyPress="return checkIt(event)" onclick="" value='<?php echo $inbox_key ?>' ></br></br>
          <input id="start_dt" name="start_dt" type="text" size="13" style="font-size: 11px" title="Start Date" onKeyPress="return checkIt(event)" onclick="this.select()" value="Start Date" ></br></br>
          <input id="end_dt" name="end_dt" type="text" size="13" style="font-size: 11px" title="End Date" onKeyPress="return checkIt(event)" onclick="this.select()" value="End Date" ></br></br>
          <input id="submit" name="Submit" type="submit" value="     Submit    " style="font-size: 11px" title="Reload Data"></br></br></br>
        </form>
      
       <script type="text/javascript">
          
                stm_bm(["menu073b",980,"","blank.gif",0,"","",0,0,0,0,1000,1,0,0,"","",0,0,1,1,"default","hand","",1,25],this);
                stm_bp("p0",[1,4,0,0,0,5,0,7,100,"stEffect(\"s\")",-2,"stEffect(\"slip\")",-2,90,0,0,"#7F7F7F","transparent","",3,0,0,"#8f7156"]);
            stm_bp("p0",[1,4,0,0,0,5,0,7,100,"",-2,"",-2,90,0,0,"#7F7F7F","transparent","",3,1,1,"#8f7156"]);
                stm_ai("p0i0",[0,"         Home   ","","",-1,-1,0,"/sta","_self","","Home Page","","",0,0,0,"","",0,0,0,1,1,"#FFCCCC",0,"#FF99CC",0,"","",3,3,0,0,"#FFFFFF #FFFFFF #000099","#FFFFFF #FFFFFF #000099","#006666","#006666","8pt Microsoft Sans Serif","8pt Microsoft Sans Serif",0,0,"","","","",0,0,0]);
                <?php
                for ($i = 0; $i < $numrowsmenu1; $i++) {
                        $rowmenu1 = mysql_fetch_array($resultmenu1);
                        $namemenu1 = $rowmenu1["service_name"];
                  
                ?>
                        stm_aix("p0i2","p0i1",[0,"<?=$namemenu1?>","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_r.gif","arrow_r.gif",7,7,0,1,1,"#CCFFCC",0,"#FFCCCC",0,"","",3,3,1,1,"#FFFFFF","#FFFFFF","#009966","#000000","8pt Microsoft Sans Serif","8pt Microsoft Sans Serif"]);
                        stm_bp("p1",[1,2,0,0,0,5,0,7,85,"stEffect(\"slip\")",-2,"stEffect(\"slip\")",-2,100,0,0,"#7F7F7F","transparent","",3,0,0,"#8F7156"]);
                    <?php
                    $querymenu2 = "select ne_name from ne where service_name='".$rowmenu1["service_name"]."'";
                    $resultmenu2 = mysql_db_query($dbname, $querymenu2);
                    $numrowsmenu2 = mysql_num_rows($resultmenu2);
                    for ($j = 0; $j < $numrowsmenu2; $j++) {
                        $rowmenu2 = mysql_fetch_array($resultmenu2);
                        $namemenu2 = $rowmenu2["ne_name"];
                    ?>
                      stm_aix("p1i0","p0i2",[0,"<?=$namemenu2?>","","",-1,-1,0,"","_self","","","","",0,0,0,"arrow_r.gif","arrow_r.gif",7,7,0,0]);
                      stm_bpx("p2","p1",[1,2,0,0,0,5,0,0]);
                        <?php
                        $querymenu3 = "select command,subcommand from command where dml='N' and ne_name='".$rowmenu2["ne_name"]."'";
                        $resultmenu3 = mysql_db_query($dbname, $querymenu3);
                        $numrowsmenu3 = mysql_num_rows($resultmenu3);
                    
                        for ($k = 0; $k<$numrowsmenu3; $k++) {
                                $rowmenu3 = mysql_fetch_array($resultmenu3);
                                $namemenu3 = $rowmenu3["command"];
                                $namesubmenu3 = $rowmenu3["subcommand"];
                        ?>
                          stm_aix("p2i0","p0i2",[0,"<?=$namemenu3?>","","",-1,-1,0,"/sta/?input_service=<?=$namemenu1?>&input_ne=<?=$namemenu2?>&input_cmd=<?=$namemenu3?>&input_subcmd=<?=$namesubmenu3?>&input_key=<?=$key?>&input_start_dt=<?=$start_dt?>&input_end_dt=<?=$end_dt?>","_blank","","","","",0,0,0,"","",0,0,1]); 
                        <?php
                        }
                        ?>
                        stm_ep();
                    <?php
                    }
                    ?>
                    stm_ep();
                <?php
                }
                ?>
                stm_ep();
                stm_em();
          
                // free result set memory
                mysql_free_result($resultmenu1);
                mysql_free_result($resultmenu2);
                mysql_free_result($resultmenu3);
          
                // close connection
                mysql_close($connection);
          
           
       </script>
      </div>
      <div id="table" style="margin-top: 80px;">
        <?php
          if(!empty($_GET['input_key']) && isset($_GET['input_key']) && ($_GET['input_key'] != "Msisdn")) {
                include('table.php');
          } else {
                print '<div class="right_block">';
                include('help.php');
                print '</div>';
          }
        ?>
      </div>
    </div>
    </div>
  </body>
</html>