<?php
include('../includes/connect.php');
include('../email/sendmail.php');

if (isset($_POST['message'])) {
    $bullyId= mysqli_real_escape_string($connection,$_POST['bullyId']);
    $sentBy=mysqli_real_escape_string($connection,$_POST['sentBy']);
    $role =mysqli_real_escape_string($connection,$_POST['role']);
    $message = mysqli_real_escape_string($connection,$_POST['message']);


$hideFromStudent = mysqli_real_escape_string($connection,$_POST['hideFromStudent']);
    $stuemail="";
    $incidentDate="";
$result = mysqli_query($connection, "INSERT conversationhistory SET BullyId=$bullyId, Message='$message', SentOn=UTC_TIMESTAMP(), SentBy='$sentBy', Role='$role', HideFromStudent='$hideFromStudent'")or die(mysqli_error($connection));
    
    
    $getresult = mysqli_query($connection,"SELECT bully.BullyId,bully.IncidentDate,s.Email as  'studentEmail' FROM `bully` inner join student s on s.StudentId=bully.StudentId where bully.BullyId=$bullyId");
    $count = mysqli_num_rows($getresult);
    
if ($count>0){
    
    while($row = mysqli_fetch_array($getresult))
    {
        $stuemail=$row['studentEmail'];  
        $bullyId=$row['BullyId'];  
        $incidentDate  =$row['IncidentDate'];  
    }
     $createDate = new DateTime($incidentDate);
     $inciDate = $createDate->format("m/d/Y");

        $mailmessage='<h1>Conversation Mail</h1><br/>
    <b>Incident Id :<b/>'.$bullyId.'<br/>
    <b>Incident Date : <b/>'.$inciDate.'<br/>
    <b>Message :<b/>'.$message.'<br/><br/>
    <b>From : </b> '.$role;
        if($stuemail!="")
        {
            $msg=sendmail($stuemail,$mailmessage,'New communication has been Updated on Incident id :'.$bullyId .' on '. date("m/d/Y"));
        }
        
}
}

?>