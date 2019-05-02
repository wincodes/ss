<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

   // Clear the error message
  $notification = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

      if (!empty($user_username) && !empty($user_password)) {
        // Look up the username and password in the database
        $query = "SELECT user_id, username FROM ss_user WHERE username = '$user_username' AND password = SHA('$user_password')";
        $data = mysqli_query($dbc, $query);

        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
          $row = mysqli_fetch_array($data);
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['username'] = $row['username'];
          setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
            echo '<script type="text/javascript">
  window.location = "index.php"
  </script>
  ';
        }
        else {
          // The username/password are incorrect so set an error message
          $notification = 'Sorry, you must enter a valid username and password to log in.';
        }
      }
      else {
        // The username/password weren't entered so set an error message
        $notification = 'Sorry, you must enter your username and password to log in.';
      }
    }
  }

  // Insert the page header
  $page_title = 'Log In';
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



  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['user_id'])) {
?>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <h4>Log In</h4>
      <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
      </div>

      <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" name="password" />
      </div>
        <input type="submit" value="Log In" name="submit" />
  </fieldset>
  </form>
  	<p> <a href="recovery.php">Recover Password</p>
<?php
  }
  else {
    // Confirm the successful log-in
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');
  }
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>