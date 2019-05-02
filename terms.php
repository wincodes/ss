<?php
 // Start the session
  require_once('startsession.php');
  // Insert the page header
  require_once('uploadpath.php');
require_once('connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Insert the page header
   $page_title = 'Terms of Use';
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
<div class="col-sm-2 col-md-2">
<?php
require_once('sportnetworks.php');
echo '<hr width="90%" size="2" align="center">';
require_once('soccernetworks.php');
?>
</div>

<div class="col-sm-6 col-md-6">
<h4 class="text-center">Terms of Use </h4>
<p class="text-justify"> This article covers the terms of use of Sport Socia (Sport Social Network) including all its Features, Pages and Events.<br /> 
Sport Social Network is free; the only requirement is to be a sport lover. <br />
These are Sport Socia/Sport Social Network terms of use:-<br />
1.	All users are responsible for their Posts, Comments and Updates<br />
2.	Only registered users are allowed to create a topic and follow a topic. unregistered users can only view and comment on topics.<br />
3.	All posts or updates must be about sport and must be within the designated Sport Forums or Network.<br />
4.	Sport Socia is not responsible for any false information or abuse by users on any sport Organization, 
personnel, event or activity.<br />
5.	Users are allowed to post or comment on all sporting events, activity, organization, personnel, news and 
updates. However abuse of any form or posts contrary to the development of sport is prohibited.<br />
6.	Direct or indirect links to other websites are not allowed, however users are only allowed this as source of their information or update.<br />
7.	Scripts, tags or any form of coding is highly prohibited.<br />
The above applies to all sport socia users in all Sport Socia features.<br />
Thanks for using Sport Socia<br />
&copy;2017 Team Sport Socia. 
</p>
</div>

<div class="col-sm-4 col-md-4">
<?php
    require_once('recent.php');
?>
</div>
<?php
require_once('footer.php');
?>