<!DOCTYPE html>
<HTML>
 <HEAD>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <TITLE>Single Tools Analysis</TITLE>
                <script type="text/javascript" charset="utf-8" src="DataTables-1.10.2/media/js/jquery.dataTables.min.js"></script>
                <script type="text/javascript" charset="utf-8" src="DataTables-1.10.2/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
                <script type="text/javascript" charset="utf-8" src="DataTables-1.10.2/extensions/ColReorder/js/dataTables.colReorder.min.js"></script>
                <script type="text/javascript" charset="utf-8" src="DataTables-1.10.2/extensions/Responsive/js/dataTables.responsive.js"></script>
                <script type="text/javascript" charset="utf-8" src="DataTables-1.10.2/extensions/FixedHeader/js/dataTables.fixedHeader.min.js"></script>
                <style type="text/css" title="currentStyle">
                        @import "DataTables-1.10.2/media/css/jquery.dataTables.min.css";
                        @import "DataTables-1.10.2/extensions/TableTools/css/dataTables.tableTools.min.css";
                        @import "DataTables-1.10.2/extensions/ColReorder/css/dataTables.colReorder.min.css";
                        @import "DataTables-1.10.2/extensions/Responsive/css/dataTables.responsive.css";
                        @import "DataTables-1.10.2/extensions/FixedHeader/css/dataTables.fixedHeader.min.css";
                </style>

                <script type="text/javascript" charset="utf-8">

                        <?php
                        $input_service = isset($_GET['input_service']) ? $_GET['input_service'] : '';
                        $input_ne = isset($_GET['input_ne']) ? $_GET['input_ne'] : '';
                        $input_cmd = isset($_GET['input_cmd']) ? $_GET['input_cmd'] : '';
                        $input_subcmd = isset($_GET['input_subcmd']) ? $_GET['input_subcmd'] : '';
                        $input_key = isset($_GET['input_key']) ? $_GET['input_key'] : '';
                        $input_start_dt = isset($_GET['input_start_dt']) ? $_GET['input_start_dt'] : '';
                        $input_end_dt = isset($_GET['input_end_dt']) ? $_GET['input_end_dt'] : '';
                        $input_input_start_dt_yyyymmdd = substr($input_start_dt,0,8);

                        if(!empty($_POST['key']) && isset($_POST['key']) && ($_POST['key'] != "Msisdn")) {
                        $input_key = $_POST['key'];
                        $input_start_dt = $_POST['start_dt'];
                        $input_end_dt = $_POST['end_dt'];
                  }


      ?>
      
                        var subcmd = "";
                        var data=location.search;
                        if(data) {
                                data=location.search.substring(1); // remove the '?'
                                data=data.split('&');
                                for(var i=0; i<data.length; i++){
          var tmp=data[i].split('=');
          if(tmp[0] == "input_subcmd") {
                subcmd = tmp[1];
          }
                                }
                        }


                        $(document).ready( function () {

                                var oTable = jQuery('#table_id').DataTable({
                                        responsive: true,
                                        "dom": 'T<"clear">Rlfrtip',
                "tableTools": {
            "sSwfPath": "/sta/DataTables-1.10.2/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                },
        
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        var initialPage = window.location.pathname;
                        if(subcmd !== "") {
                                $('td:eq(1)', nRow).html('<a href="/sta/subtable.php?input_service=<?=$input_service?>&input_ne=<?=$input_ne?>&input_cmd=<?=$input_subcmd?>&input_subcmd=&input_key1=' + aData[0] + '&input_key2=' + aData[1] + '&input_key3=' + aData[3] + '" target="_blank">' + aData[1] + '</a>');
                        }
                        return nRow;
                },
        });
        
        
        
        $('a.toggle-vis').on( 'click', function (e) {
                                        e.preventDefault();
                                        // Get the column API object
                                        var column = oTable.column( $(this).attr('data-column') );
                                        // Toggle the visibility
                                        column.visible( ! column.visible() );
        });
      });
      

                </script>
 </HEAD>

 <BODY>
        <div class="bodytable">
    <?php
      
        $mysqlhost = "localhost"; // MySQL DB Host name
        $mysqlusername = "sta"; // MySQL DB User
        $mysqlpass = "sta"; // MySQL DB User password
        $mysqldb = "sta"; // MySQL DB Name
        $mysqlquery = "select * from ne where ne_name = '".$input_ne."'";
        $mysqlconnection = mysql_connect($mysqlhost, $mysqlusername, $mysqlpass);
    
        putenv("NLS_LANG=AMERICAN_AMERICA.TH8TISASCII");
    
        if (!$mysqlconnection)
        die("Can't connect to database");
    
      if (!mysql_select_db($mysqldb))
        die("Can't select database");
    
      // sending query
      $mysqlresult = mysql_query($mysqlquery);
      if (!$mysqlresult)
        die("Query to show fields from table failed");
    
        while ($row = mysql_fetch_array($mysqlresult, MYSQL_ASSOC)) {
        $oracleusername = $row['USER'];
        $oraclepass = $row['PASSWORD'];
        $oracledb = $row['DESTINATION'];
      }
    
        $mysqlquery = "select * from command where ne_name = '".$input_ne."' and command = '".$input_cmd."'";
        $mysqlresult = mysql_query($mysqlquery);
    
        if (!$mysqlresult)
        die("Query to show fields from table failed");
        
      while ($row = mysql_fetch_array($mysqlresult, MYSQL_ASSOC)) {
        $oraclequery = $row['STATEMENT'];
      }
      
      if (strpos($oraclequery,'{start_date_yyyymmdd}')) {
        $oraclequery = str_replace("{start_date_yyyymmdd}",$input_input_start_dt_yyyymmdd,$oraclequery);
      }
    
        $oracleconnection = oci_connect($oracleusername, $oraclepass, $oracledb);
    
        if (!$oracleconnection) {
        $e = oci_error();  // For oci_execute errors pass the statement handle
        print htmlentities($e['message']);
      }
    
    
        oci_execute(oci_parse($oracleconnection, "ALTER SESSION SET NLS_DATE_FORMAT = 'DD/MM/YYYY HH24:MI:SS'"));
    
        $oracleresult = oci_parse($oracleconnection, $oraclequery);
    
        if (strpos($oraclequery,':key1')) {
                oci_bind_by_name($oracleresult, ":key1", $input_key);
        }
        if (strpos($oraclequery,':start_date')) {
                oci_bind_by_name($oracleresult, ":start_date", $input_start_dt);
        }
        if (strpos($oraclequery,':end_date')) {
                oci_bind_by_name($oracleresult, ":end_date", $input_end_dt);
        }
    
    
        $r = oci_execute($oracleresult);
        if (!$r) {
        $e = oci_error($oracleresult);  // For oci_execute errors pass the statement handle
        print htmlentities($e['message']);
        print "\n<pre>\n";
        print htmlentities($e['sqltext']);
        printf("\n%".($e['offset']+1)."s", "^");
        print  "\n</pre>\n";
      }
    
        $oraclenumfields = oci_num_fields($oracleresult);
    
    ?>
    
    <div style="color:#989898;font-size: 10px" title="Click to Show/Hide Table Columns">
        </br>
        <?php
        for($c=1; $c<=$oraclenumfields; $c++) {
                $h = $c - 1;
                $oraclecolumnname = oci_field_name($oracleresult, $c);
                print "<a class=\"toggle-vis\" data-column=\"$h\">$oraclecolumnname | </a>";
        }
        echo "";
        ?>
    </div></br>
    
    <table id="table_id" class="display responsive no-wrap" width="100%">
     <thead>
         <tr>
                <?php
                for($i=1; $i<=$oraclenumfields; $i++) {
                        $oraclecolumnname = oci_field_name($oracleresult, $i);
                        echo "<th>$oraclecolumnname</th>\n";
                }
                ?>
         </tr>
     </thead>
     <tbody>
        <?php
     
        $countlist = 0;
        while(($row = oci_fetch_array($oracleresult, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
                echo "<tr>\n";
                foreach($row as $cell) {
                        echo "  <td>".($cell !== null ? htmlentities($cell, ENT_QUOTES):" ")."</td>\n";
                }
                echo "</tr>\n";
                $countlist ++;
        }
     
        if($countlist == 0) {
                echo "<tr>\n";
                for($i=1; $i<=$oraclenumfields; $i++) {
                        echo "<td>NULL</td>\n";
                }
                echo "</tr>\n";
        }
     
     
        // Free the statement identifier when closing the connection
        oci_free_statement($oracleresult);
        oci_close($oracleconnection);
     
        mysql_free_result($mysqlresult);
        mysql_close($mysqlconnection);
     
        ?>
     </tbody>
    </table>
  </div>
 </BODY>
</HTML>