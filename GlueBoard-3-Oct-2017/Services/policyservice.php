<?php

// Include confi.php
include('connect.php');

$SchoolId = isset($_GET["SchoolId"]) ? mysqli_real_escape_string($connection,$_GET["SchoolId"]) : "";

if(!empty($SchoolId)){
    $SchoolId=stripslashes($SchoolId);
    $temp="SELECT sp.PolicyName FROM schoolpolicy sp
    inner join school s on s.schoolId=sp.schoolId
    WHERE s.SchoolUniqueCode='$SchoolId'";
$getresult = mysqli_query($connection,"SELECT sp.PolicyName FROM schoolpolicy sp
    inner join school s on s.schoolId=sp.schoolId
    WHERE s.SchoolUniqueCode='$SchoolId' order by sp.DisplayOrder");
    $policyresult =array();
    $policyname =array();
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
while($r = mysqli_fetch_array($getresult)){
$policyname[]= array("policyname"=>$r['PolicyName']);
$path =$protocol.'://'.$_SERVER['HTTP_HOST'].'/GlueBoard/images/SchoolLogo/'.$r['PolicyName'];
$policyresult[] = array("policypath"=>$path);
}
$json = array("status" => 1, "policy"=>$policyresult,"name"=>$policyname);

}else{
$json = array("status" => 0, "msg" => "Invalid SchoolId");
}
@mysqli_close($connection);

/* Output header */
header('Content-type: application/json');
echo json_encode($json);
