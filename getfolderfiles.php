<?php
//*********** Display Code ***********************
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$qte="'";

$conn_resource = db2_connect("*LOCAL","","");
if (!$conn_resource) {
	echo "Connection failed. SQL Err:";
	echo db2_conn_error();
        echo "<br>";
	echo db2_conn_errormsg();

exit();

}
//query the data:-------------------------------------------------------------------------------------------

$sql = "SET PATH = SPYDATA";                            
	 $stmt= db2_prepare($conn_resource, $sql);
	 $result = db2_execute($stmt);

//Build Sql statement for data extraction from multiple spyview data tables
$sql="";
$sql = $sql." SELECT LDXNAM,LXSEQ,LXIV1,LXIV2 FROM SPYDATA.@000237E00"; //FWAADAYRPT
$sql = $sql." ORDER BY LXIV1, LXIV2";


$stmt= db2_prepare($conn_resource,$sql);
$result = db2_execute($stmt);

  
// build array for spyview data
$record=array();
$records=array();
$count = 0;
if (!$result) {
           echo 'The db2 execute failed. ';
           echo 'SQLSTATE value: ' . db2_stmt_error();
           echo ' Message: ' .   db2_stmt_errormsg();
        }
while ($row = db2_fetch_array($stmt))
  {	$count++;
         for($i=0; $i<11; $i++)
	{
		if($i==0)
			{
			   $record["bn"]= $row[0];
			}
		else
		if($i==1)
			{
			   $record["sq"]= $row[1];
			}
		else
		if($i==2)
			{
			   $record["date"]= $row[2];
			}
		else
		if($i==3)
			{
			   $record["folder"]= $row[3];
			}
	}
	$records[$count-1] = $record;
}
if($count==0) {echo '<tr>No records found</tr>';}
echo json_encode($records);

?>
  
 