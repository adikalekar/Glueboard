<?php

// Include confi.php
include('connect.php');
include('../email/sendmail.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
   
    $FirstName = $obj->{'FirstName'};
	$LastName = $obj->{'LastName'};
	$Location = $obj->{'Location'};
    $OptionalLocation= $obj->{'OptionalLocation'};
	$Message = $obj->{'Message'};
	$FromEmail = $obj->{'Email'};
	$Emergency = $obj->{'Emergency'};
	$SchoolId = $obj->{'SchoolId'};
	$StudentId = $obj->{'StudentId'};
	
    $schId="";
    $schName="";
    $stuId="";
    $emergencymail="";
   if($Emergency=="Shootout")
   {
       $Emergency="Police";
   }
    
    $getresult = mysqli_query($connection,"SELECT sc.SchoolId,sc.SchoolName FROM school sc WHERE sc.SchoolUniqueCode='$SchoolId'");
    $count = mysqli_num_rows($getresult);
    $getresultstudent = mysqli_query($connection,"SELECT StudentId FROM student  WHERE UniqueId='$StudentId'");
    $countstudent = mysqli_num_rows($getresultstudent);
   

if ($count>0 && $countstudent>0){
     while($row = mysqli_fetch_array($getresult))
    {
         $schId=$row['SchoolId'];  
         $schName=$row['SchoolName'];
    }
    while($row = mysqli_fetch_array($getresultstudent))
    {
         $stuId=$row['StudentId'];   
    }
    
    $getresultemer = mysqli_query($connection,"SELECT * FROM emergencymailid  WHERE SchoolId='$schId'");
    $countemer = mysqli_num_rows($getresultstudent);
    
	if($countemer>0){
        
        while($row = mysqli_fetch_array($getresultemer))
    {
         $emergencymail=$row[$Emergency];   
    }
        
	$sql = "INSERT INTO `emergency_trail` (`FirstName`, `LastName`, `Location`, `Message`, `FromEmail`, `ToEmail`, `Emergency`, `SchoolId`,`StudentId`,`OptionalLocation`) VALUES ('$FirstName', '$LastName', '$Location', '$Message','$FromEmail','$emergencymail', '$Emergency','$schId','$stuId','$OptionalLocation');";
	$qur = mysqli_query($connection,$sql);
 
	if($qur){
        $msg="";
        if($emergencymail!=""){
    $mailmessage='<h1>Emergency Mail</h1>
    <b>School Name : <b/>'.$schName.' <br/>
    <b>First Name :<b/>'.$FirstName.'<br/>
    <b>Last Name :<b/>'.$LastName.'<br/>
    <b>Location (GPS) :<b/>'.$Location.'<br/>
    <b>Exact Location :<b/>'.$OptionalLocation.'<br/>
    <b>Email of Student : <b/>'.$FromEmail.'<br/>
    <b>Message Text :<b/>'.$Message.'<br/>
    ';
        $msg=sendmail($emergencymail,$mailmessage,$Emergency . ' Emergency- Need Help');
        }
        else
        {
            $msg="Emergency Email not found.";
        }
       $json = array("status" => 1, "msg" =>  $msg);
	}
      else{
		$json = array("status" => 0, "msg" =>  "Emergency Not Found.");
	}  
    }else{
		$json = array("status" => 0, "msg" =>  "Something went wrong.");
	}
}
    else
    {
       $json = array("status" => 0, "msg" => "School or Student id not found"); 
    }
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
}

@mysqli_close($connection);

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);