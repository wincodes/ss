<?php
// Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Insert the page header
   $page_title = 'About us';
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
<h4 class="text-center">About us </h4>
<p class="text-justify"> Sport socia or Sport social network is an online sport community for all sport fans. Sport Socia was founded on the idea that sporting events, personnel, athletes, organizations and supporters require an exclusive and free network.  We are passionate about the sport world and are committed to building a network where sport lovers can relate, express themselves and air their views on any sport issue. We develop continuously and we intend to cover all sporting events. We are open to any suggestions, opinions or ideas.  Feel free to <a href="contact.php">contact us</a> and we will surely reply you. Sport socia is free; the only requirement to sign up and connect with sport socia is to be a  sport lover. Ensure to read our <a href="terms.php">terms of use</a>. <br />
<strong>DEDICATED TO ALL SPORT LOVERS</strong><br />
Team Sport Social Network - @ sportsocia.com</p>


<?php
require_once('mobilesportnetworks.php');
?>

<?php
require_once('footer.php');
?>