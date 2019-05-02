<?php
require_once('../Mobile_Detect.php');
require_once('mobileuseragent.php');
  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit10'])) {
      
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
          $home_url = $_SERVER['PHP_SELF'] ;
          if (!isset($category)) {$category='';}
		if (isset($_GET['topic']) >= 1) {
		header('Location: ' . $home_url.'?category='.$category.'&topic='.$_GET['topic'].'');
}else{
		header('Location: ' . $home_url.'?category='.$category.'');
}
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
?> 
<!DOCTYPE HTML>
<html>
<head>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-3400051078619357",
    enable_page_level_ads: true
  });
</script>
<meta charset="utf-8">
<meta name="description" content="welcome to sport social network @sportsocia.com">
<meta name="keywords" content="sport forums, sport social network, soccer, sports, football">
<link rel="shortcut icon" href="favicon.ico">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
  echo '<title>Sport Socia - ' . $page_title . '</title>';
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="../screen1.css"/>
   </head>
<body>
<nav class="bodyclass">
<div class="container-fluid headerstyle">
                    <a href="index.php"><img src="../images/logo.jpg"/></a>
                    <form method="get" action="search.php">
                      <label for="Search" class="sr-only">Search Words:</label>
                                   <input type="text" id="search" name="search" class="form-control" placeholder="search"/>
                                     <button type="submit" class="btn btn-default"/>Search</button>
                                  </form>
                    
               <?php
              if (!isset($_SESSION['user_id'])) {
              echo' <ul class="nav nav-pills navbar-nav navbar-right">';
                   echo '<li role="presentation"><a href="index.php">Home</a></li>';
              	echo '<li role="presentation"><a href="forums.php">All Forums</a></li>';
              	echo '<li role="presentation"><a href="login.php">Log-in</a></li>';
                  echo '<li role="presentation"><a href="signup.php">Sign-up</a></li>';
                 echo'</ul>';
              	  } 
              	  else {
              	if (!isset($dbc)) {
              require_once('../connectvars.php');
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
              }
                $query = "SELECT * FROM ss_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
                $data = mysqli_query($dbc, $query);

                if (mysqli_num_rows($data) == 1) {
                  // The user row was found so display the other options
                  $row = mysqli_fetch_array($data);
                  echo' <ul class="nav nav-pills navbar-nav navbar-right">';
                        echo '<li role="presentation"><a href="index.php">Home</a></li>';
                        if (!empty($row['username'])) {echo '<li role="presentation"><a href="myprofile.php">'.$row['username'].'</a></li>';}
                  echo '<li role="presentation"><a href="following.php">Followed</a></li>';
              	echo '<li role="presentation"><a href="mytopics.php">My Topics</a></li>';
              	echo '<li role="presentation"><a href="forums.php">All Forums</a></li>';
              	echo '<li role="presentation"><a href="logout.php">Log-Out</a></li>';
              	 echo'</ul>';
                }
              	  }?>
<div class="container-fluid headerstyle">
</nav>
<div class="container-fluid bodyclass">
<div class="row content">
  <?php
  require('../ads.php');
  ?>