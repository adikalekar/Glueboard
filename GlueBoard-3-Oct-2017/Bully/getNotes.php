<?php

include('../includes/connect.php');

$bullyId = mysqli_real_escape_string($connection,$_GET['bullyId']);
$timezone_name = mysqli_real_escape_string($connection,$_GET['timeZone']);

$result = mysqli_query($connection,"Select c.* from conversationhistory c 
where c.Bullyid='$bullyId' ORDER BY c.SentOn desc") or die(mysqli_error($connection));

 $messages = array();
while ($row = mysqli_fetch_array( $result )) {
      $messages[] = $row;
}
$chat_converstaion = array();

if (!empty($messages)) {
  foreach ($messages as $message) {
    $msg = nl2br(htmlentities($message['Message'], ENT_NOQUOTES));
    $sentBy = ucfirst($message['SentBy']);
    $role = ucfirst($message['Role']);
      
    // create a $dt object with the UTC timezone
    $dt = new DateTime($message['SentOn'], new DateTimeZone('UTC'));
    // change the timezone of the object without changing it's time
    $dt->setTimezone(new DateTimeZone($timezone_name));
    // format the datetime
    $sentOn = $dt->format('F d, Y g:i a');
      
    if($role=='School Admin'){
        $chat_converstaion[] =   '<div class="msg_schoolAdmin"> <div class="msg_header"><span class="glyphicon glyphicon-pencil">&nbsp;</span> Note Created on ' . $sentOn . ' by ' .$sentBy. '</div><br>' . $msg . '</div>';
    }else if($role=='Counsellor'){
        $chat_converstaion[] =   '<div class="msg_counsellor"> <div class="msg_header"><span class="glyphicon glyphicon-pencil">&nbsp;</span> Note Created on ' . $sentOn . ' by ' .$sentBy. '</div><br>' . $msg . '</div>';
    }else if($role=='Student'){
        $chat_converstaion[] =   '<div class="msg_student"> <div class="msg_header"><span class="glyphicon glyphicon-pencil">&nbsp;</span> Note Created on ' . $sentOn . ' by ' .$sentBy. '</div><br>' . $msg . '</div>';
    }
      
  }
}
echo implode('', $chat_converstaion);
?>