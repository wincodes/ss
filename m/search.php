<?php
  // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Insert the page header
   $page_title = 'Search topics';
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
echo ' 
<h4 class="text-center">Search Results </h4>';
if (isset($_GET['search'])) {
if(empty($_GET['search'])){echo '<h4> Please enter a valid word to search sport social topics</h4>';
	exit();
  }

$user_search = strip_tags($_GET['search']);	

  // Connect to the database
  if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

  // Query to get the total results 
  $query = "SELECT * FROM topics WHERE topic LIKE '%$user_search%' ORDER BY topic_id DESC";
  $result = mysqli_query($dbc, $query);
  $numrows = mysqli_num_rows ($result);
 if (!empty($numrows)) {
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
$sql = "SELECT * FROM topics WHERE topic LIKE '%$user_search%' ORDER BY topic_id DESC LIMIT $offset, $rowsperpage" ;
$result = mysqli_query($dbc, $sql);
 
  
  while ($row = mysqli_fetch_array($result)) {
    echo '<div id = topic>';
	echo '<div id = topic1>';
	echo ' ' .$row['topic']. '<br />'; 
 	echo '</div>';
    echo ' ' . substr($row['text'], 0, 100) . '...<br />';
    echo 'Posted by: '. $row['username'] . ', ' . substr($row['date'], 0, 10) . ' <a href="sportforums.php?category='.$row['category'].'&topic='.$row['topic_id'].'">VIEW</a> <br />';
 	echo '<hr width="90%" size="1" align="center">';
 echo '</div>';
  } 

/******  build the pagination links ******/
// if not on page 1, don't show back links
if ( $currentpage > 1 ) {
// show << link to go back to page 1
echo " <a href='{$_SERVER['PHP_SELF']}?search=$user_search&currentpage=1'><<</a> " ;
// get previous page num
$prevpage = $currentpage - 1;
// show < link to go back to 1 page
echo " <a href='{$_SERVER['PHP_SELF']}?search=$user_search&currentpage=$prevpage'><</a> " ;
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
echo " <a href='{$_SERVER['PHP_SELF']}?search=$user_search&currentpage=$x'>$x</a> " ;
} // end else
} // end if
} // end for
// if not on last page, show forward and last page links
if ( $currentpage != $totalpages ) {
// get next page
$nextpage = $currentpage + 1;
// echo forward link for next page
echo " <a href='{$_SERVER['PHP_SELF']}?search=$user_search&currentpage=$nextpage'>></a> " ;
// echo forward link for lastpage
echo " <a href='{$_SERVER['PHP_SELF']}?search=$user_search&currentpage=$totalpages'>>></a> " ;

} // end if
/****** end build pagination links ******/
 }else{echo 'sorry, your search did not match any topics';
	exit();}
}

?>
<?php
require_once('mobilesportnetworks.php');
?>

<?php
require_once('footer.php');
?>