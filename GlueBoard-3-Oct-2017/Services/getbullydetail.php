<?php
	// Include confi.php
	include_once('connect.php');
$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
	$bullyid = isset($_GET['bullyid']) ? mysqli_real_escape_string($connection,$_GET['bullyid']) :  "";
    $timezone_name = isset($_GET['timezone']) ? mysqli_real_escape_string($connection,$_GET['timezone']) :  "";

	if(!empty($bullyid)){
		$qur = mysqli_query($connection,"select b.*,s.StatusName from `bully` b
        Left JOIN status s ON s.StatusId = b.status
        where BullyId='$bullyid'");
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
			, 'PicofAccuse' => $protocol.'://'.$_SERVER['HTTP_HOST'].'/GlueBoard/images/SchoolLogo/'.$PicofAccuse
			, 'IncidentBehaviour' => $IncidentBehaviour
			, 'AreYouVictim' => $AreYouVictim
			, 'IsAnonymous' => $IsAnonymous
			, 'status' => $status
                             , 'statusname' => $StatusName); 
		}
		$json = array("status" => 1, "info" => $result);
	}else{
		$json = array("status" => 0, "msg" => "Bully Id not found");
	}
	@mysqli_close($connection);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);