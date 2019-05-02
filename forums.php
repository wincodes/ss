<?php
 // Start the session
  require_once('startsession.php');
  // Insert the page header
  require_once('uploadpath.php');
require_once('connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Insert the page header
  $page_title = 'All Forums';
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
<div class="col-sm-2 col-md-2">
<?php
require_once('sportnetworks.php');
echo '<hr width="90%" size="2" align="center">';
require_once('soccernetworks.php');
?>
</div>

<div class="col-sm-6 col-md-6">
<?php            

echo '<strong> All Forums </strong><br />
<table class="table">
<tr>
<td><a href="sportforums.php?category=Soccer"><img src="images/soccer_icon.jpg" width = "30" height "20" alt="soccer"/></a></td>
<td><a href="sportforums.php?category=Soccer">Soccer</a></td>
</tr>

<tr>
<td><a href="sportforums.php?category=American Football"><img src="images/football.jpeg" width = "30" height "20" alt="gridiron"/></a></td>
<td><a href="sportforums.php?category=American Football">American Football</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Basketball"><img src="images/basketball.jpeg" width = "30" height "20" alt="basketball"/></a></td>
<td><a href="sportforums.php?category=Basketball">basketball</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Tennis"><img src="images/tennis.jpeg" width = "30" height "20" alt="tennis"/></a></td>
<td><a href="sportforums.php?category=Tennis">Tennis</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Hockey"><img src="images/Hockey.jpeg" width = "30" height "20" alt="Hockey"/></a></td>
<td><a href="sportforums.php?category=Hockey">Hockey</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Boxing"><img src="images/boxing.jpeg" width = "30" height "20" alt="boxing"/></a></td>
<td><a href="sportforums.php?category=Boxing">Boxing</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Cricket"><img src="images/cricket.jpeg" width = "30" height "20" alt="cricket"/></a></td>
<td><a href="sportforums.php?category=Cricket">Cricket</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Golf"><img src="images/golf.jpeg" width = "30" height "20" alt="golf"/></a></td>
<td><a href="sportforums.php?category=Golf">Golf</a></td>
</tr>

<tr>
<td>Others</td>
<td></td>
</tr>

<tr>
<td><a href="sportforums.php?category=UEFA Champions League"><img src="images/champ.jpeg" width = "30" height "20" alt="ucl"/></a></td>
<td><a href="sportforums.php?category=UEFA Champions League">UEFA Champions League</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Barclays Premier League"><img src="images/bpl.png" width = "30" height "20" alt="bpl"/></a></td>
<td><a href="sportforums.php?category=Barclays Premier League">Barclays PL</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=La Liga"><img src="images/ligabbva.jpeg" width = "30" height "20" alt="bbva"/></a></td>
<td><a href="sportforums.php?category=La Liga">Spanish La Liga</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Seria A"><img src="images/seria.jpeg" width = "30" height "20" alt="seria"/></a></td>
<td><a href="sportforums.php?category=Seria A">Seria A</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=Bundesliga"><img src="images/bundesliga.jpeg" width = "30" height "20" alt="bundsligs"/></a></td>
<td><a href="sportforums.php?category=Bundesliga">Bundesliga</a></td>
</tr>
<tr>
<td><a href="sportforums.php?category=France Ligue1"><img src="images/ligue1.jpeg" width = "30" height "20" alt="ligue1"/></a></td>
<td><a href="sportforums.php?category=France Ligue1">France Ligue1</a></td>
</tr>


</table>
';
?>
</div>
<div class="col-sm-4 col-md-4">
<?php
    require_once('recent.php');
?>
</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
