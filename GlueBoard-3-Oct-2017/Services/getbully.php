<?php
	// Include confi.php
	include_once('connect.php');

	$uniqueid = isset($_GET['uniqueid']) ? mysqli_real_escape_string($connection,$_GET['uniqueid']) :  "";
    $timezone_name = isset($_GET['timezone']) ? mysqli_real_escape_string($connection,$_GET['timezone']) :  "";

	if(!empty($uniqueid)){
		
		  $stuId="";
    $getresult = mysqli_query($connection,"SELECT StudentId FROM student sc WHERE UniqueId='$uniqueid'");
    $count = mysqli_num_rows($getresult);
//3.1.2 If the posted values are equal to the database values, then session will be created for the user.
if ($count>0){
     while($row = mysqli_fetch_array($getresult))
    {
         $stuId=$row['StudentId'];
         
    }
	$qur = mysqli_query($connection,"select b.*,s.StatusName from `bully` b
        Left JOIN status s ON s.StatusId = b.status
        where StudentId='$stuId'");
		$result =array();
		while($r = mysqli_fetch_array($qur)){
			extract($r);
            // create a $dt object with the UTC timezone
                $dt = new DateTime($r['IncidentDate'], new DateTimeZone('UTC'));
                // change the timezone of the object without changing it's time
                $dt->setTimezone(new DateTimeZone($timezone_name));
                // format the datetime
                $incidentDate = $dt->format('F d, Y g:i a');
			$result[] = array("BullyId" => $BullyId, 
                              "Victims" => $Victims
			, 'IncidentDetails' => $IncidentDetails
                              ,'Accuses'=>$Accuses
                              ,'Location'=>$Location
                              ,'IncidentDate'=>$incidentDate
			, 'PicofAccuse' => $PicofAccuse
			, 'IncidentBehaviour' => $IncidentBehaviour
			, 'AreYouVictim' => $AreYouVictim
			, 'IsAnonymous' => $IsAnonymous
			, 'status' => $status, 'statusname' => $StatusName); 
		}
		$json = array("status" => 1, "info" => $result);
	}
	}else{
		$json = array("status" => 0, "msg" => "Bully not found.");
	}
	@mysqli_close($connection);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);