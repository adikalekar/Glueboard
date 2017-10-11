<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
if(!mail("mihir@yournxt.com","My subject",$msg)) {
print_r(error_get_last())
   echo "Email not sent. " ;
} else {
   echo "Email sent!" ;
}
//mail("rizwankhan957@gmail.com","My subject",$msg);
?>