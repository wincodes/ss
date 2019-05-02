<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (isset($_GET['action'])){
if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
$action = $_GET['action'];
if($action == 'unfollow'){
$username = $_SESSION['username'];
  $id = $_GET['topic'];
$query = "DELETE FROM following WHERE topic_id = '$id' AND username = '$username'";
if( mysqli_query($dbc, $query)){
$notification ='You stop following a topic';;
}else {$notification ='Sorry, an error occurred';}
}
}


  // Insert the page header
  $page_title = 'Followed Topics';
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
  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }

    // Connect to the database
  	if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

//retrieve data from the following table
echo '<h3>Following: </h3>';
 $query = "SELECT * FROM following WHERE username = '".$_SESSION['username']."' ORDER BY follow_id DESC";
$result = mysqli_query($dbc, $query);
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
$sql = "SELECT * FROM following WHERE username = '".$_SESSION['username']."' ORDER BY follow_id DESC LIMIT $offset, $rowsperpage";
$result2 = mysqli_query($dbc, $sql);
 while ($row2 = mysqli_fetch_array($result2)) {
	 $topic_id = $row2['topic_id'];
	$query2 = "SELECT username FROM topics WHERE topic_id = ".$topic_id."";
	$result3 = mysqli_query($dbc, $query2);
	while ($row3 = mysqli_fetch_array($result3)) {
	$query4 = "SELECT * FROM topics_reply WHERE topic_id = ".$row2['topic_id']."";
	$result4 = mysqli_query($dbc, $query4);
	$numrow4 = mysqli_num_rows ($result4);

echo'<a href="sportforums.php?category='.$row2['category'].'&topic='.$row2['topic_id'].'"><strong>'.$row2['topic'].'</strong>..... by '.$row3['username'].', '.$numrow4.' comments</a> <br />' ;
echo " <strong> <a href='{$_SERVER['PHP_SELF']}?topic=$topic_id&action=unfollow'>Unfollow topic</a></strong><br />";
	echo '<hr width="90%" size="2" align="center">';
	}
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
?>
<?php
require_once ('mobilesportnetworks.php')

?>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
