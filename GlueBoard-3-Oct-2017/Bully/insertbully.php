<?php
include('../includes/connect.php');
include('../email/sendmail.php');
   
    $Victims =$_POST['VictimName'];
	$IncidentDetails = $_POST['IncidentDetails'];
	$Accuses = $_POST['Accuses'];
	$Location = $_POST['Location'];
	$IncidentDate = $_POST['IncidentDate'];
	$PicofAccuse = basename($_FILES["PictureofAccuse"]["name"]);
	$IncidentBehaviour = $_POST['IncidentBehaviour'];
    //$IncidentBehaviourValue = $_POST['IncidentBehaviourValue'];
	$AreYouVictim = $_POST['AreYouVictim'];
	$IsAnonymous = $_POST['IsAnonymous'];
	//$status = $obj->{'status'};
	$schoolId =$_POST['schooluid'];
	//$studentId = $_POST['studentId'];

    $date = new DateTime($IncidentDate);
    $IncidentDate  = $date->format('Y-m-d');
     $schId="";
    
    $schemail="";
    $stuEmail=$_POST['email'];

    $target = "../images/SchoolLogo/"; 
    $getresult = mysqli_query($connection,"SELECT sc.SchoolId,sc.Email,uu.Email as 'schoolemail', sc.logoPath FROM school sc 
    inner join users uu on uu.SchoolId=sc.SchoolId and uu.RoleId=6
    WHERE sc.SchoolUniqueCode='$schoolId'");
    $count = mysqli_num_rows($getresult);
    
if ($count>0){
     while($row = mysqli_fetch_array($getresult))
    {
         $schId=$row['SchoolId'];
         $schemail=$schemail .','.$row['schoolemail'];
    }
   
    $schemail = substr($schemail, 1);
    
    $result=mysqli_query($connection,"INSERT bully SET Victims='$Victims',IncidentDetails='$IncidentDetails',Accuses='$Accuses',Location='$Location',IncidentDate='$IncidentDate',PicofAccuse=''
,IncidentBehaviour='$IncidentBehaviour',AreYouVictim='$AreYouVictim',IsAnonymous='$IsAnonymous',SchoolId='$schId'
    ")
or die(mysqli_error($connection));
    
  $bullyId=  mysqli_insert_id($connection);
     $new_image_name = 'img_'.$bullyId .'_'. date('Y-m-d-H').'.jpg';
    if($PicofAccuse!=""){
       if(move_uploaded_file($_FILES["PictureofAccuse"]["tmp_name"],$target.$new_image_name)) 
 { 
$sql1 = "Update bully Set PicofAccuse='$new_image_name' where BullyId='$bullyId'";
	$qur1 = mysqli_query($connection,$sql1);
       }
        else { 
 echo error_get_last();
 //Gives an error if it is not ok 
 echo "Sorry, there was a problem uploading your file.".$new_image_name.'/'.$PicofAccuse; 
 } 
    }
           $createDate = new DateTime($IncidentDate);
     $inciDate = $createDate->format("m/d/Y");
        $mailmessage='<h1>Incident Mail</h1>
    <b>Victim Name : <b/>'.$Victims.' <br/>
    <b>Accuse Name :<b/>'.$Accuses.'<br/>
    <b>Incident Date :<b/>'.$inciDate.'<br/>
    <b>Location :<b/>'.$Location.'<br/>
    <b>IncidentDetails :<b/>'.$IncidentDetails.'<br/>
    ';
        
        $msg=sendmail($schemail,$mailmessage,'New Incident from web '.$bullyId .' has been created on '. date("m/d/Y"));
        $msg1=sendmail($stuEmail,$mailmessage,'New Incident '.$bullyId .' has been created on '. date("m/d/Y"));
    header("Location: insertbullyweb.php?Message=succ");
}
else
{
    header("Location: insertbullyweb.php?Message=fail");
}
    
	?>