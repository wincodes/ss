<?php
 // Start the session
  require_once('startsession.php');
  // Insert the page header
  require_once('uploadpath.php');
require_once('connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

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
          $target = GW_UPLOADPATH .date('YmdHis'). $picture;
          if (move_uploaded_file($_FILES['picture']['tmp_name'], $target)) {
            
            // Write the data to the database
            $query = "INSERT INTO topics (user_id, username, category, topic, text, date, picture) VALUES ($user_id,'$username', 'women', '$topic', '$text',NOW(), '$picture')";
            mysqli_query($dbc, $query);

            // Confirm success with the user
            $notification = 'your topic has been added.';
            
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
      $notification = "Please enter all of the information to add your topic.";
    }
 
 }else{
		
	
    $user_id =  $_SESSION['user_id'];
	$username = $_SESSION['username'];
	$topic = strip_tags(mysqli_real_escape_string($dbc, trim($_POST['topic'])));
    $text = strip_tags(mysqli_real_escape_string($dbc, trim($_POST['text'])));

    if (!empty($topic) && !empty($text)) {
     
	       // Write the data to the database
        $query = "INSERT INTO topics (user_id, username, category, topic, text, date) VALUES ($user_id,'$username', 'women', '$topic', '$text',NOW())";
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
            $notification = "reply success.";
			
            // Clear the score data to clear the form
            $text = "";}
         
        }
          else {
            $notification = "Sorry, there was a problem creating your REPLY.";
		  }
		   }

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
 $category = $row['category'];
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
  $page_title = 'Sport Gists';
  require_once('header.php');
if (isset($_GET['n']) >= 1){
	$notification = $_GET['n'];
}
if (isset($notification)) {
if (!empty($notification)) {
echo $notification;
}
$notification = "";
}
?>
<div id="colmask">
<div id="colmid">
<div id="colleft">
<div id="col1">
<?php
echo ' 
<P class="heading">SPORT GISTS  </p>';
if (isset($_GET['topic']) >= 1){
if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
$topic = $_GET['topic'];
 
 $initquery = "SELECT * FROM topics WHERE topic_id = $topic ";
 $initdata = mysqli_query($dbc, $initquery);
      if (mysqli_num_rows($initdata) == 0) {   
  echo 'the topic you selected does not exist or may have been removed';
  exit();
  }

  // Retrieve the data data from the selected gist tables
  $query = "SELECT * FROM topics WHERE topic_id = $topic";
 $result = mysqli_query($dbc, $query);
 while ($row = mysqli_fetch_array($result)) {
 echo '<div id = topic>';
	echo '<div id = topic1>';
	if (is_file(GW_UPLOADPATH . $row['picture']) && filesize(GW_UPLOADPATH . $row['picture']) > 0) {
      echo '<img src="' . GW_UPLOADPATH . $row['picture'] . '" width = "250" height "60" alt="image" />';
    }
    else {
      echo '<img src="images/no photo.gif" width = "250" height "60" alt="NO PICTURE" />';}
	  
	echo '<br />';
	echo '' .$row['topic']. '<br />'; 
    echo '</div>';
	echo '<p class="text">' .$row['text'].' </p> <br />';
	echo'<br />';
	echo 'By: <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . '<br />';


//if a user is logged in
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	
	//show edit topic if its the same user 
	if ( $_SESSION['username'] == $row['username']) {

echo '<strong><a href="edittopic.php?topic='.$row['topic_id'].'&url=gist.php">edit/delete topic</a> </strong>';
}
//show follow topic or unfollwow topic if is not the same user
$usernames = $_SESSION['username'];
 $select = "SELECT * FROM following WHERE topic_id = '$topic' AND username = '$usernames'";
      $data1 = mysqli_query($dbc, $select);
      if (mysqli_num_rows($data1) == 0) {   

if ( $_SESSION['username'] != $row['username']) {
	echo " <strong> <a href='{$_SERVER['PHP_SELF']}?topic=$topic&action=follow'>follow topic</a></strong>";
}
}else{echo " <strong> <a href='{$_SERVER['PHP_SELF']}?topic=$topic&action=unfollow'>Unfollow topic</a></strong>";}
} 
echo '</div>';
 
 
 
 echo '<div id = Replies><hr width="90%" size="2" align="center"><br />';
  echo ' <P class="heading"> comments: </p>';
  echo'<hr width="90%" size="2" align="center"><br />';
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
$sql = "SELECT * FROM topics_reply WHERE topic_id = $topic ORDER BY reply_id DESC LIMIT $offset, $rowsperpage" ;
$result = mysqli_query($dbc, $sql);
	
  while ($row2 = mysqli_fetch_array($result)) {
 
 	echo ' <p class="comments">'.$row2['reply'].'<br />';

 echo '<a href="viewprofile.php?username='.$row2['username'].'">-'.$row2['username'].'</a> - '. substr($row2['date'], 0, 16) .'<br />';
 
 if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
 if ( $_SESSION['username'] == $row2['username']) {

echo '<strong><a href="editcomment.php?reply_id='.$row2['reply_id'].'&url=gist.php?topic='.$topic.'">edit or delete comment</a> </strong><br />';
}}
 echo '<hr width="90%" size="2" align="center">'; 


 }
echo '</p>';
/******  build the pagination links ******/
// if not on page 1, don't show back links
if ( $currentpage > 1 ) {
// show << link to go back to page 1
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&currentpage=1'><<</a> " ;
// get previous page num
$prevpage = $currentpage - 1;
// show < link to go back to 1 page
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&currentpage=$prevpage'><</a> " ;
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
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&currentpage=$x'>$x</a> " ;
} // end else
} // end if
} // end for
// if not on last page, show forward and last page links
if ( $currentpage != $totalpages ) {
// get next page
$nextpage = $currentpage + 1;
// echo forward link for next page
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&currentpage=$nextpage'>></a> " ;
// echo forward link for lastpage
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic&currentpage=$totalpages'>>></a> " ;

} // end if
/****** end build pagination links ******/
 
echo '<br />';

echo '<script type="text/javascript">
var timeout = setTimeout ("location.reload (true);" ,180000 ); 
</script>
';
echo " <a href='{$_SERVER['PHP_SELF']}?topic=$topic'>refresh</a><br /> " ;
echo " <a href='{$_SERVER['PHP_SELF']}'>Back to Main Topics</a>" ;

//To reply the topic
  
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	echo '<p> post a comment </p>';
  echo '<hr />';
  echo '<form method="post" action="gist.php?topic='.$topic.'" >';
    echo '<textarea name="text" rows="10" cols="40"> </textarea><br />';
      echo '<hr />';
    echo '<input type="submit" value="reply" name="submit2" />';
  echo '</form>';
}else{echo '<p><a href="login.php">log in</a> To reply or comment </p>';}
echo '</div>';
  }



}else{

// Connect to the database
if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
  $gist_id = '';
  // Retrieve gist topics from gist tables
  $select = "SELECT * FROM topics WHERE category = 'gist' ORDER BY topic_id DESC";
 $result = mysqli_query($dbc, $select);
	$numrows = mysqli_num_rows ($result);
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
$sql = "SELECT * FROM topics WHERE category = 'gist' ORDER BY topic_id DESC LIMIT $offset, $rowsperpage" ;
$result = mysqli_query($dbc, $sql);
    
  while ($row = mysqli_fetch_array($result)) {
    echo '<div id = topic>';
	echo '<div id = topic1>';
	echo '' .$row['topic']. '<br />'; 
 	echo '</div>';
    echo ' ' . substr($row['text'], 0, 100) . '...<br />';
	$query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
	$result2 = mysqli_query($dbc, $query2);
	$numrows = mysqli_num_rows ($result2);
    echo 'Posted by: <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ', '.$numrows.' comments  <a href="gist.php?topic='.$row['topic_id'].'">VIEW</a> <br />';
 	echo '<hr width="90%" size="2" align="center">';
 echo '</div>';
  } 

/******  build the pagination links ******/
// if not on page 1, don't show back links
if ( $currentpage > 1 ) {
// show << link to go back to page 1
echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=1'><<</a> " ;
// get previous page num
$prevpage = $currentpage - 1;
// show < link to go back to 1 page
echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$prevpage'><</a> " ;
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
echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a> " ;
} // end else
} // end if
} // end for
// if not on last page, show forward and last page links
if ( $currentpage != $totalpages ) {
// get next page
$nextpage = $currentpage + 1;
// echo forward link for next page
echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a> " ;
// echo forward link for lastpage
echo " <a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a> " ;

} // end if
/****** end build pagination links ******/


echo '<br />';




//To create a new topic
if (!empty($text)){ $textT = $text ;}else{$textT = '';}
  
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
	echo '<p> Create a New Gist </p>';
  echo '<hr />';
  echo '<form enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
    echo '<input type="hidden" name="MAX_FILE_SIZE" value=" GW_MAXFILESIZE" />';
    echo '<label for="name">Gist Topic:</label>
    <input type="text" id="topic" name="topic" maxlength="100"/><br />';
    echo '<label for="text">Text:</label>
    <textarea name="text" rows="10" cols="40">'.$textT.' </textarea><br />';
      echo '<p> add an optional picture... max '.$maxupload.' </p>';
	  echo '<label for="picture">picture:</label>
    <input type="file" id="picture" name="picture" />';
	  echo '<hr />';
    echo '<input type="submit" value="create topic" name="submit" />';
  echo '</form>';
}else{echo '<p><a href="login.php">log in</a> To create a Gist Topic </p>';}



}

?>
</div>
<div id="col2">
<?php
require_once('sportnetworks.php');
?>
</div>

<div id="col3">
<?php
require_once('soccernetworks.php');
?>
</div>
</div>
</div>
</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
