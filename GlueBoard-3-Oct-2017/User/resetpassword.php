<?php
include('../includes/authenticate.php');
include('../includes/header.php');
if (isset($_GET['Message'])) {
    if($_GET['Message']=="succ"){
    print '<script type="text/javascript">toastr.success("Password has been update sucessfully.");</script>';
    }
    else if($_GET['Message']=="errnot"){
    print '<script type="text/javascript">toastr.error("Your new and Retype Password is not match.");</script>';
    }
    else if($_GET['Message']=="errold"){
    print '<script type="text/javascript">toastr.error("Your old password is wrong.");</script>';
    }else if($_GET['Message']=="newold"){
    print '<script type="text/javascript">toastr.error("Old Password and new password cannot be same.");</script>';
    }
}
?>
<html>
     <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Password Change</title>
     </head>
    <body>
    <div class='container'>
<div class='panel panel-default'>
<div class='panel-heading'>
					<h5 class='panel-title checkbox'>						
                             <span style=''>Change Password</span>
						</h5>
				</div>
<div class='panel-body'>
   <form method="POST" action="changepassword.php">
       <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">Enter your existing password:</label>
        <div class="col-xs-8 col-md-8">
      <input type="password" class="form-control" name="password" required>
        </div>
    </div>
   	</div>
         <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field">Enter your new password:</label>
        <div class="col-xs-8 col-md-8">
      <input type="password" class="form-control" name="newpassword" required>
        </div>
    </div>
   	</div>
            <div class="form-group">
    <div class="row">
      <label for="lastname" class="col-xs-4 col-md-3 control-label required-field"> Re-enter your new password:</label>
        <div class="col-xs-8 col-md-8">
      <input type="password" class="form-control" name="confirmnewpassword" required>
        </div>
                </div></div>
       <div class="form-group">
                   <div class="row">
						<div class="col-xs-12 col-md-12 buttons-container">
							<div class="edit-butons">
								<button id="singlebutton" name="submit" class="btn btn-primary btn-sm">Update Password</button>
								
							</div>
						</div>
					</div>
   	</div>
    
       </form>
    </div>
        </div></div>
   </body>
    </html>  