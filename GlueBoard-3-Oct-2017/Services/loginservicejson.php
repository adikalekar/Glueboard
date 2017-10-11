<?php

// Include confi.php
include('connect.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	// Get data
	//$SchoolID = isset($_POST['SchoolID']) ? mysqli_real_escape_string($connection,$_POST['SchoolID']) : "";
	//$FirstName = isset($_POST['FirstName']) ? mysqli_real_escape_string($connection,$_POST['FirstName']) : "";
	//$LastName = isset($_POST['LastName']) ? mysqli_real_escape_string($connection,$_POST['LastName']) : "";
	//$UniqueId = isset($_POST['UniqueId']) ? mysqli_real_escape_string($connection,$_POST['UniqueId']) : "";
    $SchoolID =$obj->{'SchoolID'};
    $FirstName=$obj->{'FirstName'};
     $LastName=$obj->{'LastName'};
        $UniqueId=$obj->{'UniqueId'};
	$getresult = mysqli_query($connection,"SELECT sc.SchoolId, sc.logoPath FROM school sc WHERE sc.SchoolUniqueCode='$SchoolID'");
    $getresult1 = mysqli_query($connection,"SELECT sp.PolicyName FROM schoolpolicy sp
    inner join school s on s.schoolId=sp.schoolId
    WHERE s.SchoolUniqueCode='$SchoolID' order by sp.PolicyId desc");

   $schId="";
    $path="";
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
	
	$count = mysqli_num_rows($getresult);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
if ($count>0){
     while($row = mysqli_fetch_array($getresult))
    {
         $schId=$row['SchoolId'];
         $path=$row['logoPath'];
    }
	  
    $filenamepattern = '/'.basename(__FILE__).'/';
	// Insert data into data base
	$sql = "INSERT INTO `student`(`StudentId`, `FirstName`, `LastName`, `SchoolId`, `UniqueId`) VALUES (NULL,'$FirstName','$LastName','$schId','$UniqueId');";
	$qur = mysqli_query($connection,$sql);
	if($qur){
		$logoresult =array();
        $policyresult =array();
		$logopath =$protocol.'://'.$_SERVER['HTTP_HOST'].'/GlueBoard/images/SchoolLogo/'.$path;
        $logoresult[] = array("logoPath" => $logopath,);
           
        while($r = mysqli_fetch_array($getresult1)){
            $policypath =$protocol.'://'.$_SERVER['HTTP_HOST'].'/GlueBoard/images/SchoolLogo/'.$r['PolicyName'];
			$policyresult[] = array("policypath"=>$policypath);
		}
		$json = array("status" => 1, "logo" => $logoresult,"policy"=>$policyresult);
	}else{
		$json = array("status" => 0, "msg" => "Error... Something went wrong.");
	}
}else{
//3.1.3 If the login credentials doesn't match, he will be shown with an error message.
$json = array("status" => 0, "msg" => "Invalid SchoolID");
}

	
}
//else{
//	$json = array("status" => 0, "msg" => "Request method not accepted");
//}

@mysqli_close($conn);

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);