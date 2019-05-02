<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Insert the page header
  $page_title = 'sport forums, sport social network';
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

require_once('mobilesportnetworks.php');
?>
<?php
echo '<P  class="text-center"><strong>Recent Forum Topics</strong></p>';
// Connect to the database
if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
  
  $query = "SELECT * FROM topics ORDER BY topic_id DESC LIMIT 15";
 $result = mysqli_query($dbc, $query);
  while ($row = mysqli_fetch_array($result)) {
	$topic = $row['topic_id'];
	echo '<div id = topic1>';
		echo '<P  class="text-center"><strong> <a href="sportforums.php?topic='.$topic.'&category='.$row['category'].'">' .$row['topic']. '</a></strong></p>'; 
    echo '</div>';
	echo '<p class="text-justify">' . substr($row['text'], 0, 250) . '...</p>';
	$query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
	$result2 = mysqli_query($dbc, $query2);
	$numrows = mysqli_num_rows ($result2);
    echo '<small>by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ', ' .$numrows.' comments</small>';
  	echo '<hr width="90%" size="1" align="center">';
  }
  require('../ads.php');
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>