<?php

// Include confi.php
include('connect.php');
include('../email/sendmail.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);

if($_SERVER['REQUEST_METHOD'] == "POST"){
	
    $BullyId = $obj->{'BullyId'};
	$Message = $obj->{'Message'};
	$SentOn = 'Now()';
	$SentBy = $obj->{'SentBy'};
	$Role = "Student";
   $counemail="";
    $schemail="";
    $bullyId="";
    $incidentDate="";
    $getresult = mysqli_query($connection,"SELECT bully.BullyId,bully.IncidentDate, u.Email as 'counemail',uu.Email as 'schoolemail' FROM `bully` 
left join users u on u.UserId=bully.CounselorId 
inner join school s on s.SchoolId=bully.SchoolId
inner join users uu on uu.SchoolId=bully.SchoolId and uu.RoleId=6 WHERE bully.bullyid='$BullyId'");
    $count = mysqli_num_rows($getresult);
   
if ($count>0){
    
    while($row = mysqli_fetch_array($getresult))
    {
        $counemail=$row['counemail'];  
        $schemail=$schemail .','.$row['schoolemail'];
        $bullyId=$row['BullyId'];  
        $incidentDate  =$row['IncidentDate'];  
    }
    $schemail = substr($schemail, 1);
    $data="INSERT INTO `conversationhistory` (`BullyId`, `Message`, `SentOn`, `SentBy`, `Role`) VALUES ('$BullyId', '$Message', '$SentOn', '$SentBy', '$Role');";
   $sql = "INSERT INTO `conversationhistory` (`BullyId`, `Message`, `SentOn`, `SentBy`, `Role`) VALUES ('$BullyId', '$Message', UTC_TIMESTAMP(), '$SentBy', '$Role');";
    
	$qur = mysqli_query($connection,$sql);
	if($qur){
        $createDate = new DateTime($incidentDate);

$inciDate = $createDate->format("m/d/Y");

        $mailmessage='<h1>Conversation Mail</h1><br/>
    <b>Incident Id :<b/>'.$bullyId.'<br/>
    <b>Incident Date : <b/>'.$inciDate.'<br/>
    <b>Message :<b/>'.$Message.'<br/><br/>
    <b>From : Student</b> 
    ';
        if($counemail=="")
        {
            $msg=sendmail($schemail,$mailmessage,'New communication has been Updated on Incident id :'.$BullyId .' on '. date("m/d/Y"));
        }
        else
        {
            $msg=sendmail($counemail,$mailmessage,'New communication has been Updated on Incident id :'.$BullyId .' on '. date("m/d/Y"));
        }
          
		$json = array("status" => 1, "msg" => "Message has been added successfully!");
	}else{
		$json = array("status" => 0, "msg" =>  'Something went wrong.');
	}
}
    else
    {
       $json = array("status" => 0, "msg" => "Bully id not found"); 
    }
}else{
	$json = array("status" => 0, "msg" => "Request method not accepted");
}

@mysqli_close($connection);

/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);