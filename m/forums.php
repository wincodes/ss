<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Insert the page header
  $page_title = 'All Forums';
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

echo '<p align="center"><strong> All Sport Forums</strong><br />
<a href="sportforums.php?category=Soccer">General Soccer</a><br />
<a href="sportforums.php?category=UEFA Champions League">UEFA Champions League</a><br />
<a href="sportforums.php?category=Barclays Premier League"> Barclays Premier League</a><br />
<a href="sportforums.php?category=La Liga">Spanish La Liga</a><br />
<a href="sportforums.php?category=Seria A"> Seria A</a><br />
<a href="sportforums.php?category=Bundesliga"> Bundesliga</a><br />
<a href="sportforums.php?category=France Ligue1">France League1</a><br />
<a href="sportforums.php?category=American Football"> American Football</a><br />
<a href="sportforums.php?category=Basketball"> Basketball</a><br />
<a href="sportforums.php?category=Tennis"> Tennis|</a><br />
<a href="sportforums.php?category=Golf"> Golf</a><br />
<a href="sportforums.php?category=Hockey"> Hockey</a><br />
<a href="sportforums.php?category=Boxing"> Boxing</a><br />
<a href="sportforums.php?category=Cricket"> Cricket</a><br />
</p>
';
echo '<hr width="90%" size="1" align="center">';
?>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
