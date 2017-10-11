<?PHP
include('../includes/connect.php');
if(!empty($_POST["username"])) {
$result = mysqli_query($connection,"SELECT count(*) FROM users WHERE Username='" . $_POST["username"] . "'");
$row = mysqli_fetch_row($result);
$user_count = $row[0];
if($user_count>0)
{echo "<span class='status-not-available'>Username already exist.</span>";}
else 
{echo "<span class='status-available'>Username Available.</span>";}
}
?>