
<?php
     
function valid($id,$name, $address,$email ,$logo ,$schooluniquecode,$phone, $error)
{
if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>

<div class='modal-header'>
          <h4 class='modal-title'>Edit School</h4>
</div>
<div class='modal-body'>
			<div class="panel panel-default">				
				<div class="panel-body">
<form action="editschool.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $id; ?>"/>
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
      <textarea class="form-control" rows="3" name="address" required><?php echo $address; ?></textarea>
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
                <img src="../images/SchoolLogo/<?php echo $logo; ?>" width="100px" height="100px" style="border:1px solid #333333; margin-left: 30px;"/>
                
      <input type="file" class="form-control" name="pic" accept=".jpg,.jpeg,.png,.bmp,.gif"> <span><?php echo $logo;?></span>
                <input type="hidden" name="lbllogo" value="<?php echo $logo; ?>">
    </div>
            </div>
    </div>
    
<div class="row">
						<div class="col-xs-12 col-md-12 modal-footer buttons-container">
							<div class="edit-butons">
    <button id="singlebutton" name="submit" class="btn btn-primary btn-sm" onClick="return validate();">Save</button>
                                <a href="#" class="btn btn-primary btn-sm" id= "cancelUser" data-dismiss='modal'>Cancel</a>
                            </div></div></div>
    </form>
                </div></div></div>
<?php
}
include('../includes/connect.php');

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

if (is_numeric($_POST['id']))
{
$id = $_POST['id'];
$target = "../images/SchoolLogo/"; 
$target = $target . basename( $_FILES['pic']['name']);
$pic=($_FILES['pic']['name']);  
    if($pic=="")
    {
        $pic= mysqli_real_escape_string($connection,$_POST['lbllogo']);;
    }
$name = mysqli_real_escape_string($connection,$_POST['name']);
$address = mysqli_real_escape_string($connection,$_POST['address']);
$email = mysqli_real_escape_string($connection,$_POST['email']);
//$schooluniquecode = mysqli_real_escape_string($connection,$_POST['schooluniquecode']);
$phone = mysqli_real_escape_string($connection,$_POST['phone']);
$logo=$pic;
mysqli_query($connection,"UPDATE school SET SchoolName='$name',Address='$address',Email='$email',logoPath='$pic',Phone='$phone'  WHERE SchoolId=$id")
or die(mysqli_error($connection));
if(move_uploaded_file($_FILES['pic']['tmp_name'], $target)) 
 { 
 
 //Tells you if it is all ok 
 echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded, and your information has been added to the directory"; 
 } 
 else { 
 
 //Gives an error if it is not ok 
 echo "Sorry, there was a problem uploading your file."; 
 } 

 header("location: schoolview.php?Message=edit");

}
else
{

echo 'Error!';
}
}
else
{
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
{
$id = $_GET['id'];
$result = mysqli_query($connection,"SELECT * FROM school WHERE schoolid='$id'")
or die(mysqli_error($connection));
$row = mysqli_fetch_array($result);

if($row)
{
$name = $row['SchoolName'];
$address = $row['Address'];
$email = $row['Email'];
$logo = $row['logoPath'];
$schooluniquecode = $row['SchoolUniqueCode'];
$phone = $row['Phone'];
valid($id,$name,$address,$email,$logo,$schooluniquecode,$phone,'');
}
else
{
echo "No results!";
}
}
else
{
echo 'Error!';
}
}
?>