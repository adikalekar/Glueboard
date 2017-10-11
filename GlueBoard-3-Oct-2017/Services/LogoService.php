<?php

// Include confi.php
include('connect.php');

$SchoolId = isset($_GET['SchoolId']) ? mysqli_real_escape_string($connection,$_GET['SchoolId']) : "";

if(!empty($SchoolId)){
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
$filenamepattern = '/'.basename(__FILE__).'/';
$getresult = mysqli_query($connection,"SELECT * FROM school WHERE schoolId='$SchoolId'");
while($r = mysqli_fetch_array($getresult)){
extract($r);
$path =$protocol.'://'.$_SERVER['HTTP_HOST'].'/GlueBoard/images/SchoolLogo/'.$logoPath;
$result[] = array("SchoolId" => $SchoolId, "logoPath" => $path);
}
$json = array("status" => 1, "info" => $result);

}else{
$json = array("status" => 0, "msg" => "Error.. Something went wrong!");
}
@mysqli_close($conn);

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
