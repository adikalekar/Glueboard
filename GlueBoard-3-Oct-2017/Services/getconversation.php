<?php
	// Include confi.php
	include_once('connect.php');

	$bullyId = isset($_GET['bullyId']) ? mysqli_real_escape_string($connection,$_GET['bullyId']) :  "";
    $timezone_name = isset($_GET['timezone']) ? mysqli_real_escape_string($connection,$_GET['timezone']) :  "";

	if(!empty($bullyId)){
		$qur = mysqli_query($connection,"SELECT * FROM `conversationhistory`
        where BullyId='$bullyId' and HideFromStudent<>'Y' OR HideFromStudent IS NULL order by senton desc");
		$result =array();
		while($r = mysqli_fetch_array($qur)){
			extract($r);
                // create a $dt object with the UTC timezone
                $dt = new DateTime($r['SentOn'], new DateTimeZone('UTC'));
                // change the timezone of the object without changing it's time
                $dt->setTimezone(new DateTimeZone($timezone_name));
                // format the datetime
                $sentOn = $dt->format('F d, Y g:i a');
			$result[] = array("BullyId" => $BullyId
                              ,'Message'=>$Message
                              ,'SentOn'=>$sentOn
                              ,'SentBy'=>$SentBy
                              ,'Role'=>$Role
                             ); 
		}
		$json = array("status" => 1, "info" => $result);
	}else{
		$json = array("status" => 0, "msg" => "Conversation not found.");
	}
	@mysqli_close($connection);

	/* Output header */
	header('Content-type: application/json');
	echo json_encode($json);