<?php

function valid($name, $address,$email ,$logo ,$schooluniquecode,$phone, $error)
{
?>
<?php
if ($error != '')
{
echo '  <div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>
<div class='modal-header'>
          <h4 class='modal-title'>Add School</h4>
</div>
<div class='modal-body'>
			<div class="panel panel-default">				
				<div class="panel-body">
<form action="insertschool.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
    <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">School Name:</label>
        <div class="col-xs-8 col-md-8"> 
      <input type="text" class="form-control"  name="name" required value="<?php echo $name; ?>">
        </div>
     </div>           
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Email:</label>
        <div class="col-xs-8 col-md-8">
      <input type="email" class="form-control" name="email"required value="<?php echo $email; ?>">
    </div>
    </div>
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Address:</label>
            <div class="col-xs-8 col-md-8">
      <textarea class="form-control" rows="3" name="address"required value="<?php echo $address; ?>"></textarea>
    </div>
            </div>
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">Phone:</label>
            <div class="col-xs-8 col-md-8">
      <input type="text" class="form-control" name="phone" required value="<?php echo $phone; ?>">
    </div>
            </div>
    </div>
    <div class="form-group">
        <div class="row">
      <label class="col-xs-4 col-md-3 control-label required-field">School Logo:</label>
            <div class="col-xs-8 col-md-8">
      <input type="file" class="form-control" name="logo" accept=".jpg,.jpeg,.png,.bmp,.gif" required>
    </div>
            </div>
    </div>
    
<div class="row">
						<div class="col-xs-12 col-md-12 modal-footer buttons-container">
							<div class="edit-butons">
    <button id="singlebutton" name="submit" class="btn btn-primary btn-sm">Save</button>
                                <a href="#" class="btn btn-primary btn-sm" id= "cancel" data-dismiss='modal'>Cancel</a>
                            </div></div></div>
</form>
</div></div>                   
</div>
<?php
}

include('../includes/connect.php');
function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}
function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
if (isset($_POST['submit']))
{
$target = "../images/SchoolLogo/"; 
   
 $target = $target . basename( $_FILES['logo']['name']);
 $pic=($_FILES['logo']['name']); 
$name = mysqli_real_escape_string($connection,$_POST['name']);
$address = mysqli_real_escape_string($connection,$_POST['address']);
$email = mysqli_real_escape_string($connection,$_POST['email']);
$logo = '';
$schooluniquecode = getToken(7);
$phone = mysqli_real_escape_string($connection,$_POST['phone']);

$result=mysqli_query($connection,"INSERT school SET SchoolName='$name',Address='$address',Email='$email',logoPath='$pic',SchoolUniqueCode='$schooluniquecode',Phone='$phone'")
or die(mysqli_error($connection));
if(move_uploaded_file($_FILES['logo']['tmp_name'], $target)) 
 { 
 
 //Tells you if it is all ok 
 echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded, and your information has been added to the directory"; 
 } 
 else { 
 
 //Gives an error if it is not ok 
 echo "Sorry, there was a problem uploading your file."; 
 } 
 header("Location: schoolview.php?Message=insert");

}
else
{
valid('','','','','','','');
}
?>