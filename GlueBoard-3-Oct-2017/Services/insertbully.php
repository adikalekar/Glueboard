<?php

// Include confi.php
include('connect.php');
include('../email/sendmail.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);

if($_SERVER['REQUEST_METHOD'] == "POST"){
	// Get data
   
    $Victims = $obj->{'VictimName'};
	$IncidentDetails = $obj->{'IncidentDetails'};
	$Accuses = $obj->{'Accuses'};
	$Location = $obj->{'Location'};
	$IncidentDate = $obj->{'IncidentDate'};
	$PicofAccuse = $obj->{'PictureofAccuse'};
	$IncidentBehaviour = $obj->{'IncidentBehaviour'};
    $IncidentBehaviourValue = $obj->{'IncidentBehaviourValue'};
	$AreYouVictim = $obj->{'AreYouVictim'};
	$IsAnonymous = $obj->{'IsAnonymous'};
	//$status = $obj->{'status'};
	$schoolId = $obj->{'schoolId'};
	$studentId = $obj->{'studentId'};

    $date = new DateTime($IncidentDate );
    $IncidentDate  = $date->format('Y-m-d H:i:s');
     $schId="";
    $stuId="";
    $schemail="";
    $stuEmail="";
    $getresult = mysqli_query($connection,"SELECT sc.SchoolId,sc.Email,uu.Email as 'schoolemail', sc.logoPath FROM school sc 
    inner join users uu on uu.SchoolId=sc.SchoolId and uu.RoleId=6
    WHERE sc.SchoolUniqueCode='$schoolId'");
    $count = mysqli_num_rows($getresult);
    $getresultstudent = mysqli_query($connection,"SELECT StudentId,Email FROM student  WHERE UniqueId='$studentId'");
    $countstudent = mysqli_num_rows($getresultstudent);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
if ($count>0 && $countstudent>0){
     while($row = mysqli_fetch_array($getresult))
    {
         $schId=$row['SchoolId'];
         $schemail=$schemail .','.$row['schoolemail'];
    }
    while($row = mysqli_fetch_array($getresultstudent))
    {
         $stuId=$row['StudentId'];
        $stuEmail=$row['Email'];
    }
    $schemail = substr($schemail, 1);
	// Insert data into data base
	$sql = "INSERT INTO `bully` (`BullyId`, `Victims`, `IncidentDetails`, `Accuses`, `Location`, `IncidentDate`, `PicofAccuse`, `IncidentBehaviour`, `AreYouVictim`, `IsAnonymous`,`StudentId`,`SchoolId`) VALUES (NULL, '$Victims', '$IncidentDetails', '$Accuses', '$Location', '$IncidentDate', '', '$IncidentBehaviour', '$AreYouVictim', '$IsAnonymous','$stuId','$schId');";
	$qur = mysqli_query($connection,$sql);
  $bullyId=  mysqli_insert_id($connection);
	if($qur){
        if($PicofAccuse!=""){
        $datax = base64_decode($PicofAccuse);
    $target = "../images/SchoolLogo/"; 
        
        $new_image_name = 'img_'.$bullyId .'_'. date('Y-m-d-H').'.jpg';
        file_put_contents($target.$new_image_name, $datax);
        $sql1 = "Update bully Set PicofAccuse='$new_image_name' where BullyId='$bullyId'";
	$qur1 = mysqli_query($connection,$sql1);
        }
        $createDate = new DateTime($IncidentDate);
     $inciDate = $createDate->format("m/d/Y");
        $mailmessage='<h1>Incident Mail</h1>
    <b>Victim Name : <b/>'.$Victims.' <br/>
    <b>Accuse Name :<b/>'.$Accuses.'<br/>
    <b>Incident Behaviour :<b/>'.$IncidentBehaviourValue.'<br/>
    <b>Incident Date :<b/>'.$inciDate.'<br/>
    ';
        
        $msg=sendmail($schemail,$mailmessage,'New Incident '.$bullyId .' has been created on '. date("m/d/Y"));
        if($stuEmail!=""){
        $msg=sendmail($stuEmail,$mailmessage,'New Incident '.$bullyId .' has been created on '. date("m/d/Y"));
        }
		$json = array("status" => 1, "msg" => "Bully has been added successfully!");
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