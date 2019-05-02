<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

 
if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
if (isset($_POST['submit'])) {
$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $message = mysqli_real_escape_string($dbc, trim($_POST['message']));
	$username = $_POST['username'];
if (!empty($email) && !empty($message)){
  
  // Write the data to the database
            $query = "INSERT INTO contact (username, email, message, date) VALUES ('$username', '$email', '$message', NOW())";
            if( mysqli_query($dbc, $query)){

            // Confirm success with the user
            $notification = 'message sent, you will get a reply soon';
			}
}else{$notification = 'fields cannot be empty';}
}

 // Insert the page header
   $page_title = 'Contact Us';
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
if (isset($_SESSION['username'])){
	$username = $_SESSION['username'];
}else{
	$username = 'none';
}
echo ' 
<h4>Contact Site Administrator </h4>';
  echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<input type="hidden" name="username" value="'.$username.'" />';
    echo '
    <div class="form-group">
    <label for="email">email:</label>
    <input class="form-control" type="text" id="email" name="email"  maxlength="100"/>
    </div>';
    
    echo '
    <div class="form-group">
    <label for="message">Message:</label>
    <textarea class="form-control" name="message" rows="10" cols="30"> </textarea></div>';
       echo '<input type="submit" value="Send Message" name="submit" />';
  echo '</form>';
    echo '<hr />';
?>
<?php
require_once('mobilesportnetworks.php')
?>

<?php
require_once('footer.php');
?>