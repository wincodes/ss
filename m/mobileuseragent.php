<?php
$detect = new Mobile_Detect;

$iphone = strpos( $_SERVER
[ 'HTTP_USER_AGENT' ],"iPhone");
$android = strpos( $_SERVER
[ 'HTTP_USER_AGENT' ],"Android ");
$palmpre = strpos( $_SERVER
[ 'HTTP_USER_AGENT' ],"webOS ");
$berry = strpos( $_SERVER
[ 'HTTP_USER_AGENT' ],"BlackBerry
");
$ipod = strpos( $_SERVER
[ 'HTTP_USER_AGENT' ],"iPod");


if ($iphone || $android || $detect->isMobile() ||
$palmpre || $ipod || $berry ==
true && !$detect->isTablet() )
{
//do nothing
}else{
//if its not a mobile device redirect to desktop
		if (isset($_GET['topic']) >= 1){
	$topic = $_GET['topic'];
	if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
  $query = "SELECT * FROM topics WHERE topic_id = $topic ";
 $result = mysqli_query($dbc, $query);
 while ($row = mysqli_fetch_array($result)) {
 $category = $row['category'];
 $topic = $row['topic_id'];
  }
header ('Location: ../sportforums.php?category='.$category.'&topic='.$topic.'' );
	}else{
header( 'Location: ../index.php' );
}

}

?>
