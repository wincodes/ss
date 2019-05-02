<?php
 // Start the session
  require_once('startsession.php');
  // Insert the page header
  require_once('uploadpath.php');
require_once('connectvars.php');
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
<div class="col-sm-2 col-md-2">
    <?php
    require_once('sportnetworks.php');
      
echo '<hr width="90%" size="2" align="center">';
    require_once('soccernetworks.php');
require('ads.php');
    ?>
</div>

<div class="col-sm-6 col-md-6">
   
      <?php
      // Connect to the database
      if (!isset($dbc)) {
      require_once('connectvars.php');
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      }
        
require_once('indexrecent.php');
require('ads.php');

      ?>
</div>

<div class="col-sm-4 col-md-4">
<?php
require('ads.php');

        // Retrieve the data data from selected MySQL tables

 $query = "SELECT * FROM topics WHERE category = 'Basketball' ORDER BY topic_id DESC LIMIT 3";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=Basketball&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',   <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }


 $query = "SELECT * FROM topics WHERE category = 'Tennis' ORDER BY topic_id DESC LIMIT 2";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=Tennis&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',   <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }

 $query = "SELECT * FROM topics WHERE category = 'Soccer' ORDER BY topic_id DESC LIMIT 3";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=Soccer&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }


 $query = "SELECT * FROM topics WHERE category = 'American Football' ORDER BY topic_id DESC LIMIT 2";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=American Football&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',   <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }

require('ads.php');
 

 $query = "SELECT * FROM topics WHERE category = 'Golf' ORDER BY topic_id DESC LIMIT 1";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=Golf&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }


 $query = "SELECT * FROM topics WHERE category = 'Hockey' ORDER BY topic_id DESC LIMIT 2";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=Hockey&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }


 $query = "SELECT * FROM topics WHERE category = 'Boxing' ORDER BY topic_id DESC LIMIT 1";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=Boxing&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }

        $query = "SELECT * FROM topics WHERE category = 'Barclays Premier League' ORDER BY topic_id DESC LIMIT 2";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=Barclays Premier League&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',   <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }

 
 $query = "SELECT * FROM topics WHERE category = 'La Liga' ORDER BY topic_id DESC LIMIT 1";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=La Liga&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',   <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }

 $query = "SELECT * FROM topics WHERE category = 'UEFA Champions League' ORDER BY topic_id DESC LIMIT 1";
       $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
        $topic = $row['topic_id'];
          echo '<strong><a href="sportforums.php?category=UEFA Champions League&topic='.$topic.'&/'.$row['topic'].'">' .$row['topic']. '</a></strong><br />'; 
          echo '<p class="text-justify">' . substr($row['text'], 0, 150) . '...</p>';
        $query2 = "SELECT * FROM topics_reply WHERE topic_id = ".$row['topic_id']."";
        $result2 = mysqli_query($dbc, $query2);
        $numrows = mysqli_num_rows ($result2);
          echo '
          <small>
          by <a href="viewprofile.php?username='.$row['username'].'">'.$row['username'].'</a>, ' . substr($row['date'], 0, 10) . ',   <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> '.$numrows.'</small>';
          echo '<hr width="90%" size="2" align="center">';
        }
  require('ads.php');
    
?>
  
</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>