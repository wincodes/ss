<?php
 // Start the session
  require_once('startsession.php');
  // Insert the page header
  require_once('uploadpath.php');
require_once('connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//check if topicid and category is set if its not redirect to homepage
if (isset($_GET['category'])){
	//set the category
	$category = $_GET['category'];
//if category is empty redirect to homepage
if ($category  == ''){header ('Location: index.php');} 
}
else{
//the category is not set redirect to homepage
header ('Location: index.php');
}

//create the topic
if (isset($_POST['submit'])) {

    // check if picture is set

 if (!empty($_FILES['picture']['name'])) {
 $user_id =  $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$topic = strip_tags(mysqli_real_escape_string($dbc, trim($_POST['topic'])));
    $text = strip_tags(mysqli_real_escape_string($dbc, trim($_POST['text'])));
  $picture = $_FILES['picture']['name'];
    $picture_type = $_FILES['picture']['type'];
    $picture_size = $_FILES['picture']['size']; 

    if (!empty($topic) && !empty($text) && !empty($picture)) {
      if ((($picture_type == 'image/gif') || ($picture_type == 'image/jpeg') || ($picture_type == 'image/pjpeg') || ($picture_type == 'image/png'))
        && ($picture_size > 0) && ($picture_size <= GW_MAXFILESIZE)) {
        if ($_FILES['picture']['error'] == 0) {
          // Move the file to the target upload folder
          $target = GW_UPLOADPATH .$picture;
          if (move_uploaded_file($_FILES['picture']['tmp_name'], $target)) {
            
            // Write the data to the database
            $query = "INSERT INTO topics (user_id, username, category, topic, text, date, picture) VALUES ($user_id,'$username', '$category', '$topic', '$text',NOW(), '$picture')";
            mysqli_query($dbc, $query);

            // Confirm success with the user
            $notification = 'your topic has been created.';
            
            // Clear the score data to clear the form
            $topic = "";
            $text = "";
			$screenshot = "";
				  }
          else {
            $notification = "Sorry, there was a problem uploading the image.";
          }
        }
      }
      else {
        $notification = "The image must be a GIF, JPEG, or PNG image file no greater than ".$maxupload." in size.";
      }

      // Try to delete the temporary screen shot image file
      @unlink($_FILES['picture']['tmp_name']);
    }
    else {
      $notification = "Please enter all of the information to create your topic.";
    }
 
 }else{
		
	
    $user_id =  $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$topic = strip_tags(mysqli_real_escape_string($dbc, trim($_POST['topic'])));
    $text = strip_tags(mysqli_real_escape_string($dbc, trim($_POST['text'])));

    if (!empty($topic) && !empty($text)) {
     
	       // Write the data to the database
        $query = "INSERT INTO topics (user_id, username, category, topic, text, date) VALUES ($user_id,'$username', '$category', '$topic', '$text',NOW())";
           if( mysqli_query($dbc, $query)){

            // Confirm success with the user
            $notification = "your topic has been created.";
			
            // Clear the score data to clear the form
            $topic = "";
            $text = "";}
         
        }
          else {
            $notification = "Sorry, there was a problem creating your topic.";
		  }
		   }
}
//create the reply
if (isset($_POST['submit2'])) {

    // Grab the score data from the POST
    $user_id =  $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$topic_id = $_GET['topic'];
    $text = strip_tags(mysqli_real_escape_string($dbc, trim($_POST['text'])));

    if (!empty($topic_id) && !empty($text)) {
     
	       // Write the data to the database
            $query = "INSERT INTO topics_reply (topic_id, user_id, username, reply, date) VALUES ($topic_id , $user_id ,'$username', '$text', NOW())";
           if( mysqli_query($dbc, $query)){

            // Confirm success with the user
            $notification = "your comment was successful.";
			
            // Clear the score data to clear the form
            $text = "";}
         
        }
          else {
            $notification = "Sorry, there was a problem creating your comment.";
		  }
		   }
//create the reply for unregistered users
if (isset($_POST['submit3'])) {
	
    // Grab the score data from the POST
	$username = $_POST['username'];
	$email = $_POST['email'];
	$topic_id = $_GET['topic'];
    $text = strip_tags(mysqli_real_escape_string($dbc, trim($_POST['text'])));

    if (!empty($topic_id) && !empty($text) && !empty($username) && !empty($email)) {
     
	       // Write the data to the database
            $query = "INSERT INTO topics_reply (topic_id, username, email, reply, date) VALUES ($topic_id, '$username', '$email', '$text', NOW())";
           if( mysqli_query($dbc, $query)){

            // Confirm success with the user
            $notification = "Your comment was successful.";
			
            // Clear the score data to clear the form
            $text = "";}else {
            $notification = "Sorry, there was a problem creating your Comment.";}//end of data writing
        }else {
            $notification = "please fill all the required fields.";}
		//end of topic and text check
   }//end of post


//Allow a user follow the topic
if (isset($_GET['action'])){
if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
$action = $_GET['action'];
if ($action == 'follow'){ 
$username = $_SESSION['username'];
	$id = $_GET['topic'];
  $query = "SELECT * FROM topics WHERE topic_id = $id ";
 $result = mysqli_query($dbc, $query);
 while ($row = mysqli_fetch_array($result)) {
 $title = $row['topic'];
  }
if (!empty($username) && !empty($id) && !empty($title) && !empty($category)) {
 
 //check if user already follow this topic
 $select = "SELECT * FROM following WHERE topic_id = '$id' AND username = '$username'";
      $data = mysqli_query($dbc, $select);
      if (mysqli_num_rows($data) == 0) {   
	 
	 	     // Write the data to the database
 $insert = "INSERT INTO following (topic_id, topic, username, category) VALUES ($id, '$title', '$username', '$category')";
           if( mysqli_query($dbc, $insert)){
            // Confirm success with the user
            $notification = "You now follow this topic.";
			}
          else {
            $notification = "Sorry, a problem occurred  while following the topic.";
		  }
	  }else { $notification = "you already follow this topic";}
}
}
if($action == 'unfollow'){
$username = $_SESSION['username'];
	$id = $_GET['topic'];
$query = "DELETE FROM following WHERE topic_id = '$id' AND username = '$username'";
if( mysqli_query($dbc, $query)){
echo 'You no longer follow this topic';
}else {$notification = "sorry, an error occurred";}
}
}
    // Insert the page header
  $page_title = $category;
  require_once('header.php');
   require_once('images.php');
	
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
<div class="col-sm-2 col-md-2">
<?php
if ($category == 'Soccer' or $category == 'Barclays Premier League' or $category == 'La Liga' or $category == 'France Ligue1'
or $category == 'Bundesliga' or $category == 'women' or $category == 'UEFA Champions League' or $category == 'Seria A'
){
  
require_once('soccernetworks.php');
echo '<hr width="90%" size="2" align="center">';
require_once('sportnetworks.php');
}else{
require_once('sportnetworks.php');
echo '<hr width="90%" size="2" align="center">';
require_once('soccernetworks.php');
}
require('ads.php');
?>
</div>

<div class="col-sm-6 col-md-6">
<?php            
echo ' 
<P  class="text-center"><strong>'.$category.' Forum</strong></p>';
//check if the topic id is set
if (isset($_GET['topic']) >= 1){
if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
$topic = $_GET['topic'];

//check if topic is set if it is not tell user the topic is not set
 $initquery = "SELECT * FROM topics WHERE topic_id = $topic ";
 $initdata = mysqli_query($dbc, $initquery);
      if (mysqli_num_rows($initdata) == 0) {   
  echo 'the topic you selected does not exist or may have been removed';
  exit();
  }

  // Retrieve the topic if it is set
  $query = "SELECT * FROM topics WHERE topic_id = $topic ";
 $result = mysqli_query($dbc, $query);
 while ($row = mysqli_fetch_array($result)) {
 echo '<div id = topic>';
	echo '<div id = topic1>';
	if (is_file(GW_UPLOADPATH . $row['picture']) && filesize(GW_UPLOADPATH . $row['picture']) > 0) {
      echo '<img src="' . GW_UPLOADPATH . $row['picture'] . '" class="img-responsive center-block" alt="image" />';
    }
    else {
      echo '<img src="images/'.$image.'" class="img-responsive center-block" alt="soccer icon" />';}
	   echo '<hr width="90%" size="2" align="center">';
	echo '<h4 class="text-primary"> ' .$row['topic']. '</h4><br />'; 
    echo '</div>';
	echo '<p class="text-justify">'.nl2br($row['text']).' </p> <br />';
	echo '<small>Posted by: <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a> , ' . substr($row['date'], 0, 16) . '</small><br />';

//if a user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	
	//show edit topic if its the same user 
	if ( $_SESSION['username'] == $row['username']) {

echo '<strong><a href="edittopic.php?topic='.$row['topic_id'].'&category='.$category.'">edit/delete topic</a> </strong>';
}
//show follow topic or unfollwow topic if is not the same user
$usernames = $_SESSION['username'];
 $select = "SELECT * FROM following WHERE topic_id = '$topic' AND username = '$usernames'";
      $data1 = mysqli_query($dbc, $select);
      if (mysqli_num_rows($data1) == 0) {   

if ( $_SESSION['username'] != $row['username']) {
	echo " <strong> <a href='{$_SERVER['PHP_SELF']}?topic=$topic&category=$category&action=follow'>follow topic</a></strong>";
}
}else{echo " <strong> <a href='{$_SERVER['PHP_SELF']}?topic=$topic&category=$category&action=unfollow'>Unfollow topic</a></strong>";}
}
 echo '</div>';
 
 //Get the comments or replies
 echo '<hr width="90%" size="0.2" align="center">';
  $query2 = "SELECT * FROM topics_reply WHERE topic_id = $topic ORDER BY reply_id DESC";
  $result2 = mysqli_query($dbc, $query2);
	$numrows = mysqli_num_rows ($result2);
	// number of rows to show per page
	$rowsperpage = 15;
	// find out total pages
	$totalpages = ceil ( $numrows / $rowsperpage );
	// get the current page or set a default
if ( isset ( $_GET [ 'currentpage' ]) && is_numeric ( $_GET [ 'currentpage' ])) {
// cast var as int
$currentpage = (int ) $_GET [ 'currentpage' ];
} else {
// default page num
$currentpage = 1;
} // end if
// if current page is greater than total pages...
if ( $currentpage > $totalpages ) {
// set current page to last page
$currentpage = $totalpages ;
} // end if
// if current page is less than first page...
if ( $currentpage < 1 ) {
// set current page to first page
$currentpage = 1;
} // end if
// the offset of the list, based on current page
$offset = ($currentpage - 1) * $rowsperpage ;
$sql = "SELECT * FROM topics_reply WHERE topic_id = $topic ORDER BY reply_id ASC LIMIT $offset, $rowsperpage" ;
$result = mysqli_query($dbc, $sql);
	
  while ($row2 = mysqli_fetch_array($result)) {
	  echo ' <a href="viewprofile.php?username='.$row2['username'].'">'.$row2['username']. ' |</a>';
 	 if ($row2['user_id'] == NULL) echo '(Unregistered User)';
echo '<br><small class="text-muted"> '. substr($row2['date'], 0, 16) .'</small>';
	echo '<p class="text-justify">'.nl2br($row2['reply']).'</p>';
  if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
 if ( $_SESSION['username'] == $row2['username'] && !$row2['user_id'] == NULL) {
echo '<strong><a href="editcomment.php?reply_id='.$row2['reply_id'].'&category='.$category.'&topic='.$topic.'">edit or delete comment</a> </strong><br />';
}}
echo '<hr width="90%" size="0.2" align="center"></p>'; 
 }
/******  build the pagination links ******/
// if not on page 1, don't show back links
if ( $currentpage > 1 ) {
// show << link to go back to page 1
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&category=$category&currentpage=1'><<</a> " ;
// get previous page num
$prevpage = $currentpage - 1;
// show < link to go back to 1 page
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&category=$category&currentpage=$prevpage'><</a> " ;
} // end if
// range of num links to show
$range = 3 ;
// loop to show links to range of pages around current page
for ( $x = ( $currentpage - $range ); $x < (($currentpage + $range ) + 1 ); $x ++) {
// if it's a valid page number...
if (($x > 0 ) && ( $x <= $totalpages )) {
// if we're on current page...
if ( $x == $currentpage ) {
// 'highlight' it but don't make a link
echo " [<b>$x</b>] " ;
// if not current page...
} else {
// make it a link
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&category=$category&currentpage=$x'>$x</a> " ;
} // end else
} // end if
} // end for
// if not on last page, show forward and last page links
if ( $currentpage != $totalpages ) {
// get next page
$nextpage = $currentpage + 1;
// echo forward link for next page
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&category=$category&currentpage=$nextpage'>></a> " ;
// echo forward link for lastpage
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&category=$category&currentpage=$totalpages'>>></a> " ;

} // end if
/****** end build pagination links ******/
echo '<br />';
echo '<script type="text/javascript">
var timeout = setTimeout ("location.reload (true);" ,180000 ); 
</script>
';
//To reply the topic
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	  echo '<hr />';
  echo '<h5> post a comment </h5>';
  echo '<form method="post" action="topics.php?topic='.$topic.'&category='.$category.'" >
  <div class="form-group">
  ';
    echo '<textarea name="text" rows="5" cols="40"> </textarea><br />';
      echo '<hr />';
    echo '<input type="submit" value="comment" name="submit2" />';
  echo '
  </div>
  </form>';
}else{
		echo '<p class="text-danger">* Fields are compulsory </p>';
  echo '<hr />';
  echo '<form role="form" method="post" action="topics.php?topic='.$topic.'&category='.$category.'" >
  ';
    echo '
  <div class="form-group">
    <label for="name">* Name:</label>
    <input type="text" id="username" name="username" maxlength="100"/>
    </div>
    <br />';
	echo '
<div class="form-group">
  <label for="email">* Email:</label>
    <input type="text" id="email" name="email" maxlength="100"/>
    </div>
    <br />';
	echo '
  <div class="form-group">
  <label for="comment">* Comment:</label>
  <textarea name="text" rows="10" cols="40"> </textarea>
</div>
  <br />';
      echo '<hr />';
    echo '<input type="submit" value="comment" name="submit3" />';
  echo '
  </form>';
	}
//end of the comment or reply
  echo'<hr>';
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&category=$category'>Refresh Topic</a><br /> " ;
echo " <a href='{$_SERVER['PHP_SELF']}?category=$category'>Back to Main Topics</a>" ;
  }
}else{
//if topic id is not set
// Connect to the database
if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
  $topic = '';
  // Retrieve general_soccer topics from topics tables
  $select = "SELECT * FROM topics WHERE category = '$category' ORDER BY topic_id DESC";
 $result = mysqli_query($dbc, $select);
	$numrows = mysqli_num_rows ($result);
	// number of rows to show per page
	$rowsperpage = 10;
	// find out total pages
	$totalpages = ceil ( $numrows / $rowsperpage );
	// get the current page or set a default
if ( isset ( $_GET [ 'currentpage' ]) && is_numeric ( $_GET [ 'currentpage' ])) {
// cast var as int
$currentpage = (int ) $_GET [ 'currentpage' ];
} else {
// default page num
$currentpage = 1;
} // end if
// if current page is greater than total pages...
if ( $currentpage > $totalpages ) {
// set current page to last page
$currentpage = $totalpages ;
} // end if
// if current page is less than first page...
if ( $currentpage < 1 ) {
// set current page to first page
$currentpage = 1;
} // end if
// the offset of the list, based on current page
$offset = ($currentpage - 1) * $rowsperpage ;
$sql = "SELECT * FROM topics WHERE category = '$category' ORDER BY topic_id DESC LIMIT $offset, $rowsperpage" ;
$result = mysqli_query($dbc, $sql);
    
  while ($row = mysqli_fetch_array($result)) {
echo '<strong><a href="topics.php?topic='.$row['topic_id'].'&category='.$category.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong>'; 
    echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
	$query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
	$result2 = mysqli_query($dbc, $query2);
	$numrows = mysqli_num_rows ($result2);
    echo '
    Posted by: <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>,  ' . substr($row['date'], 0, 10) . ',   <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>  '.$numrows.'</p>';
 	echo '<hr width="90%" size="0.2" align="center">';

  } 
/******  build the pagination links ******/
// if not on page 1, don't show back links
if ( $currentpage > 1 ) {
// show << link to go back to page 1
echo " <a href='{$_SERVER['PHP_SELF']}?category=$category&currentpage=1'><<</a> " ;
// get previous page num
$prevpage = $currentpage - 1;
// show < link to go back to 1 page
echo " <a href='{$_SERVER['PHP_SELF']}?category=$category&currentpage=$prevpage'><</a> " ;
} // end if
// range of num links to show
$range = 3 ;
// loop to show links to range of pages around current page
for ( $x = ( $currentpage - $range ); $x < (($currentpage + $range ) + 1 ); $x ++) {
// if it's a valid page number...
if (($x > 0 ) && ( $x <= $totalpages )) {
// if we're on current page...
if ( $x == $currentpage ) {
// 'highlight' it but don't make a link
echo " [<b>$x</b>] " ;
// if not current page...
} else {
// make it a link
echo " <a href='{$_SERVER['PHP_SELF']}?category=$category&currentpage=$x'>$x</a> " ;
} // end else
} // end if
} // end for
// if not on last page, show forward and last page links
if ( $currentpage != $totalpages ) {
// get next page
$nextpage = $currentpage + 1;
// echo forward link for next page
echo " <a href='{$_SERVER['PHP_SELF']}?category=$category&currentpage=$nextpage'>></a> " ;
// echo forward link for lastpage
echo " <a href='{$_SERVER['PHP_SELF']}?category=$category&currentpage=$totalpages'>>></a> " ;

} // end if
/****** end build pagination links ******/


echo '<br />';


//To create a new topic
if (!empty($text)){ $textT = $text ;}else{$textT = '';}
  
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	
  echo '<hr />';
  echo '<h5> Create a New Topic </h5>';
  echo '<form enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '?category='.$category.'">';
    echo '<input type="hidden" name="MAX_FILE_SIZE" value=" GW_MAXFILESIZE" />';
    echo '
<div class="form-group">
    <label for="topic">Topic:</label>
    <input class="form-control" type="text" id="topic" name="topic" maxlength="100"/>
    </div>';
    echo '
    <div class="form-group">
    <label for="text">Text:</label>
    <textarea class="form-control" name="text" rows="10" cols="40">'.$textT.'</textarea></div>';
      echo '<span id="helpBlock" class="help-block"> add an optional picture... max '.$maxupload.' </span>';
	  echo '<label for="picture">picture:</label>
    <input type="file" id="picture" name="picture" />';
	  echo '<hr />';
    echo '<input type="submit" value="create topic" name="submit" />';
  echo '</form>';
}else{echo '<p><a href="login.php">log in</a> To create a New Topic </p>';}



}
require('ads.php');
?>
</div>

<div class="col-sm-4 col-md-4">
<?php
require('ads.php');
    require_once('recent.php');
?>
</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>