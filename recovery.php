<?php
 // Start the session
  require_once('startsession.php');
  // Insert the page header
  require_once('uploadpath.php');
require_once('connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Insert the page header
  $page_title = 'Password recovery';
  require_once('header.php');
if (isset($_GET['n']) >= 1){
	$notification = $_GET['n'];
}
if (isset($notification)) {
if (!empty($notification)) {
echo'<p class="bg-warning">'.$notification.'</p>';
}
$notification = "";
}
?>
<?php
if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

//change the password
if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
	$oldpassword = $_POST['ref'];
	
	
    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
     
	    // The data is ok, change the password
		$query = "UPDATE ss_user SET password = SHA('$password1') WHERE username = '$username'";
        if(mysqli_query($dbc, $query)){
        // Confirm success with the user
        echo '<p>Your password has been changed please <a href="login.php">log in</a> to your account.</p>';} 
		else {
			echo "an error occurred while changing your password please go back and try again";
			exit();
			}
	}else{
	echo'invalid password or password dont match';
	exit();
	}
	}
	
//send a verification email
if (isset($_POST['submit2'])) {
	$mail = $_POST['mail'];
    
$query = "SELECT * FROM ss_user WHERE email = '$mail' LIMIT 1";
      $data = mysqli_query($dbc, $query) ;
      if (mysqli_num_rows($data) == 0) {
		  echo'email does not exhist';
		  exit();
	  }else{
		  $row = mysqli_fetch_array($data);
		  $username =  $row['username'];
		  $ref =  $row['password'];
$subject = 'Sport Socia Password Reset link';
  $msg = " Hello $username to reset your password click the link below or 
  copy and paste in your browser:
  	www.sportsocia.com/recovery.php?username=$username&ref=$ref";
  mail($mail, $subject, $msg);
echo 'A password reset link has been sent, Please check your Mail Inbox or Spam Folder.';		  
	  exit();
	  }
	
	
	}
?>
<?php
echo ' 
<h4 class="text-center">Recover Password</h4>';
//check if database connections are set
if (isset($_SESSION['user_id'])) {
  echo 'you are already logged in';
	exit();
}

if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

//check if the username and ref is set
if (isset($_GET['username']) && isset($_GET['ref'])){
$username = $_GET['username'];
$ref = $_GET['ref'];
 
 $query = "SELECT * FROM ss_user WHERE password = '$ref' AND username = '$username'";
      $data = mysqli_query($dbc, $query) ;
      if (mysqli_num_rows($data) == 0) {
		  echo'invalid data, plese retry';
		  exit();
	  }else{
		  $row = mysqli_fetch_array($data);
		  echo'hi <strong>' . $row['username'] .'</strong> set new password ';
echo'<fieldset>';
	echo'<legend> Reset Password </legend>';
	echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<label for="password1">New Password:</label>
      <input type="password" id="password1" maxlength="20" name="password1" />
     <br />';
	  
	echo'<label for="password1">Confirm Password:</label>
      <input type="password" id="password2" maxlength="20" name="password2" />
     <br />';  
	  
    echo '<input type="submit" value="change password" name="submit" />';
    echo '<input type="hidden" name="username" value="' .$username.'" />';
	echo '<input type="hidden" name="ref" value="' .$ref.'" />';
    echo '</form>';
	echo'</fieldset>';
}
  
}
else{
	echo' <div class="col-sm-9 col-md-9">';
	echo'<p> enter your registration e-mail to get a password reset link</p>'; 
		echo'<fieldset>';
	echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
	echo '<div id="form-group">';
	echo '<label for="email">Enter your e-mail:</label>
      <input type="text" id="mail" maxlength="50" name="mail" />
     <br />';
	echo'</div>';
	echo '<input type="submit" value="send mail" name="submit2" />';
    echo '</form>';
	echo'</fieldset>';
	echo'</div>';
	}
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>