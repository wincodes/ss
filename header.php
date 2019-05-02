<?php
require_once('Mobile_Detect.php');
require_once('useragent.php');


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
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="welcome to sport social network @sportsocia.com">
<meta name="keywords" content="sport forums, sport social network, soccer, sports, football">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-3400051078619357",
          enable_page_level_ads: true
     });
</script>
<link rel="shortcut icon" href="favicon.ico">
<?php
  echo '<title>sport socia - ' . $page_title . '</title>';
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="screen1.css"/>
</head>

<body>
<?php include_once("analyticstracking.php") ?>

<nav class="navbar bodyclass">
  <div class="container-fluid headerstyle">
   <div class="navbar-header">
      <button type="button" class="btn btn-primary navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar btn-default"></span>
        <span class="icon-bar btn-default"></span>
        <span class="icon-bar btn-default"></span>
      </button>
      <a class="navbar-brand" href="index.php"><img src="images/logo.jpg"/></a>
    </div>
   
      
            <form class="navbar-form navbar-left" method="get" action="search.php">
       		  <div class="form-group">
                      <label for="Search" class="sr-only">Search Words:</label>
                     <input type="text" id="search" name="search" class="form-control" placeholder="search"/>
                    </div>
                      <button type="submit" class="btn btn-default"/>Search</button>
                    </form> 
                  
         	 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" role="navigation">
                     <?php
                          if (!isset($_SESSION['user_id'])) {
                        echo'   
                    
                   <ul class="nav nav-pills navbar-nav navbar-right">
                       <li role="presentation"> <a href="index.php">Home</li><li role="presentation"><a href="forums.php">Forums</a></li>
                    
                            <li role="presentation" class="dropdown">   
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Log In<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                    <li>';
                          if (!isset($category)) {$category='';}
                          if (isset($_GET['topic']) >= 1) {
                          echo'  <form class="navbar-form" method="post" action="' . $_SERVER['PHP_SELF'] .'?category='.$category.'&topic='.$_GET['topic'].'">';
                          }else{
                          echo'  <form class="navbar-form navbar-left" method="post" action="' . $_SERVER['PHP_SELF'] .'?category='.$category.'">';
                        }
                          echo' 

                          <div class="form-group">
                           <label for="username" class="sr-only">Username:</label>
                              <input type="text" class="form-control" placeholder="username" name="username"/>
                                <label for="password" class="sr-only">Password:</label>
                                <input type="password" class="form-control" placeholder="password" name="password" />
                            </div>
                            <button type="submit" class="btn btn-default" name="submit10"/>Log In</button>
                           </form>
                    </li>
                    </ul>
                    </li>
                    <li role="presentation"><a href="signup.php">Sign up</a></li>
                       <li role="presentation"><a href="recovery.php">Recover Password</a></li>
                          </ul>
                          ';
                          	  } 
                          	  else {
                          
                          	if (!isset($dbc)) {
                          require_once('connectvars.php');
                            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                          }
                            $query = "SELECT * FROM ss_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
                            $data = mysqli_query($dbc, $query);

                            if (mysqli_num_rows($data) == 1) {
                              // The user row was found so display the other options
                              $row = mysqli_fetch_array($data);
                          
                          echo'
                          <ul class="nav navbar-nav navbar-right">	
                          	<li> <a href="index.php">Home</a></li>
                          	<li><a href="forums.php">Forums</a></li>

                        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                            <li> <a href="myprofile.php">' . $row['username'] . '</a></li>
                            <li><a href="following.php"> Followed Topics </li>
                          	<li><a href="mytopics.php"> My Topics </a></li>
                          	<li> <a href="logout.php">Log Out</a></li>
                    </ul>
                    <li>

              </ul>';
                                                      	
                         }
                          	  }
                    ?>
       </div>          
    </div>
  </nav>
<div class="container-fluid bodyclass">
<div class="row content">