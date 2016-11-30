<?php

//*********** Display Code ***********************
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);


if($_SERVER['HTTP_ORIGIN'] == "http://as400.bass-net.com:8080")
{
    header('Access-Control-Allow-Origin: http://as400.bass-net.com:8080');
    header('Content-type: application/x-www-form-urlencoded');
}
//http://as400.bass-net.com:10088/testjm/kendoui/examples/grid/searchlease.php?lease=00025
//get variables------------------------------------------------------------------------------------------------
//$date = "";


//-------------------------------------------------------------------------------------------------------------
$date=$_GET["date"];  //index number


$userin=$_GET["u"];
if($userin==null or $userin=='' or $userin==' ') {
$userin = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $userin = strtr($userin, '.', 'I');
    }

//set defaults --------------------------------------------------------------------------------------------   
if($date==null or $date=='' or $date==' ') {$date='';}

if($date!='' )
    {
        require 'getfolderfile.php';
    }
else
    {
        if($folder != '')
        {require 'getfolderfiles.php';}
        else {echo 'Enter search criteria.';}
     }
?>