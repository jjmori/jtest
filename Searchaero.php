<?php
if($_SERVER['HTTP_ORIGIN'] == "http://as400.bass-net.com:8080")
{
    header('Access-Control-Allow-Origin: http://as400.bass-net.com:8080');
    header('Content-type: application/x-www-form-urlencoded');
}
//http://as400.bass-net.com:10088/sidrich/CE/getsrcpb.php?v2=all&v3=all&v4=all&v5=APPEND
//get variables-------------------------------------------------------------------------------------------
$v1=$_GET["v1"];  //index 1
$v2=$_GET["v2"];  //index 2

//set defaults --------------------------------------------------------------------------------------------   
if($v1==null or $v1=='' or $v1==' ') {$v1='all';}
if($v2==null or $v2=='' or $v2==' ') {$v2='all';}

$qte="'";

//connect to database db2----------------------------------------------------------------------------------
$conn_resource = db2_connect("*LOCAL","","");
if (!$conn_resource) {
	echo "Connection failed. SQL Err:";
	echo db2_conn_error();
        echo "<br>";
	echo db2_conn_errormsg();

exit();

}


//query the data:-------------------------------------------------------------------------------------------
$sql="";
$sql=$sql."SELECT LDXNAM,LXSEQ,LXIV1,LXIV2 FROM SPYDATA.@000237E00";
echo $sql;
$stmt= db2_prepare($conn_resource,$sql);
$result = db2_execute($stmt);$sql = "SET PATH = SPYDATA";                            

//create html table from search results:---------------------------------------------------------------------------    
    $flds = 4;
       if (!$result) {
             echo 'Error occured!';
             echo $sql;
             echo 'The db2 execute failed. ';
             echo 'SQLSTATE value: ' . db2_stmt_error();
             echo ' Message: ' .   db2_stmt_errormsg();
        }
        else
        { 
          echo '<html><head>';
	  echo '<link rel="stylesheet" type="text/css" href="http://as400.bass-net.com:8080/profoundui/userdata/css/sidrich/CE/hitlist.css"/>';
	  echo '</head><body>';
	  echo '<table width="98.9%"><colgroup><col width="2%"><col width="2%"><col width="6%"><col width="21%"><col width="4.5%"><col width="21%"><col width="21%"><col width="21%"></colgroup><tr><th></th><th>Plt</th><th>Job</th><th>Title</th><th>Type</th><th>Section</th><th>SubSection1</th><th>SubSection2</th></tr></table>';
	  echo '<div style="height:95%;overflow-y:scroll;"><table width="100%">';
	  echo '<colgroup><col width="2%"><col width="2%"><col width="6%"><col width="21%"><col width="4.5%"><col width="21%"><col width="21%"><col width="21%"></colgroup>';
	  $row='';
	  
          while ($row = db2_fetch_array($stmt)) 
          {
          	$outfld = $outfld . '<tr>';
		$outfld=$outfld.'<td style="padding:0px;"><a href=';
		$outfld=$outfld.'"http://ce.bass-net.com/contentexplorer/servlet/VipDms?DN=VIP86&NAME=SRCENGDRW&TYPE=BI&B='.$row[0].'&S='.$row[1].'"';
		$outfld=$outfld.' target="_blank"><img src="http://as400.bass-net.com:8080/profoundui/userdata/images/icons/CE/doc_pcf.gif" alt="Image" width="21" height="18"></a></td>';
          	for($i=2; $i<$flds; $i++){
            	$outfld = $outfld.'<td>'.trim($row[$i]).'</td>';
		}
		$outfld = $outfld . '</tr>'; 
            	 echo  $outfld;
		 $outfld = ' ';
          }
	  echo '</table><div></body></html>';
       } 
     if ($outfld == null) {echo 'No documents found.';} //nothing was found
     echo $ctr;
}
else {echo 'Please select search criteria.'; }  //bad parms
?> 
