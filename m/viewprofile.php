<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Insert the page header
  $page_title = 'View Profile';
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
//check if data base connections are set
  	if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

//check if a user is selected
if (isset($_GET['username'])){
  // Grab the profile data from the database
 $query = "SELECT username, first_name, last_name, gender, birthdate, city, state, country, email, fav_sports, picture FROM ss_user WHERE username = '" . $_GET['username'] . "'";
  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);
    echo '<strong>  '.$row['username'].' </strong>';
	    if (!empty($row['picture'])) {
      echo '<img src="' . GW_UPLOADPATH . $row['picture'] .
        '" class="img-responsive center-block" alt="Profile Picture" />';
    }
	echo '<table class="table">';
  if (!empty($row['username'])) {
      echo '<tr><td>Username:</td><td>' . $row['username'] . '</td></tr>';
    }
    if (!empty($row['first_name'])) {
      echo '<tr><td>First name:</td><td>' . $row['first_name'] . '</td></tr>';
    }
    if (!empty($row['last_name'])) {
      echo '<tr><td>Last name:</td><td>' . $row['last_name'] . '</td></tr>';
    }
    if (!empty($row['gender'])) {
      echo '<tr><td>Gender:</td><td>';
      if ($row['gender'] == 'M') {
        echo 'Male';
      }
      else if ($row['gender'] == 'F') {
        echo 'Female';
      }
	   echo '</td></tr>';
    }
    if (!empty($row['birthdate'])) {
        // Show the user their own birthdate
        echo '<tr><td>Birthdate:</td><td>' . substr($row['birthdate'], 8, 10) . '' . substr($row['birthdate'], 4, 3) . '</td></tr>';
      
    }
    if (!empty($row['city']) || !empty($row['state'])) {
      echo '<tr><td>Location:</td><td>' . $row['city'] . ', ' . $row['state'] . ' ' . $row['country'] . '</td></tr>';
    }
     if (!empty($row['email'])) {
        // Show the user their own birthdate
        echo '<tr><td>e-mail:</td><td>' . $row['email'] . '</td></tr>';
	 }
	 if (!empty($row['fav_sports'])) {
        // Show the user their own birthdate
        echo '<tr><td>favourite sports:</td><td>' . $row['fav_sports'] . '</td></tr>';
      
    }
    echo '</table>';
  } // End of check for a single row of user results
else {
    echo '<p class="error">Profile not found.</p>';
    }
}
else {
    echo '<p class="error">Please select a user.</p>';
    }

?>

<?php
  // Insert the page footer
  require_once('footer.php');

?>
