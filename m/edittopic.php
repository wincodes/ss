<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
  
$category = $_GET['category'];

if (isset($_POST['submit'])) {
	if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
	$topic = mysqli_real_escape_string($dbc, trim($_POST['topic']));
    $text = mysqli_real_escape_string($dbc, trim($_POST['text']));
	$topic_id = $_POST['topic_id'];
	$oldpicture = $_POST['oldpicture'];
	$newpicture = $_FILES['newpicture']['name'];
    $newpicture_type = $_FILES['newpicture']['type'];
    $newpicture_size = $_FILES['newpicture']['size']; 
	
	if (!empty($topic) && !empty($text)){
	
	if (!empty($newpicture)){
	
		$query = "UPDATE topics SET topic = '$topic', text = '$text', picture = '$newpicture' WHERE topic_id = $topic_id"; 
	
	  if ((($newpicture_type == 'image/gif') || ($newpicture_type == 'image/jpeg') || ($newpicture_type == 'image/pjpeg') || ($newpicture_type == 'image/png'))
        && ($newpicture_size > 0) && ($newpicture_size <= GW_MAXFILESIZE)) {
        if ($_FILES['newpicture']['error'] == 0) {
          // Move the file to the target upload folder
          $target = GW_UPLOADPATH . $newpicture;
          if (move_uploaded_file($_FILES['newpicture']['tmp_name'], $target)) {
			
			if (mysqli_query($dbc, $query)){
			if (!empty($newpicture)) {
			@unlink(GW_UPLOADPATH . $oldpicture);
			}
			$notification = "your topic has been updated";
			header ('Location: sportforums.php?topic='.$topic_id.'&category='.$category.'&n='.$notification.'');
			}
			}
			else{$notification = "Sorry, there was a problem uploading the image.";
				@unlink($_FILES['picture']['tmp_name']);}
		}else{$notification = "Sorry, there was a problem uploading the image.";
					@unlink($_FILES['picture']['tmp_name']);}
		}else{ $notification = "The image must be a GIF, JPEG, or PNG image file no greater than ".$maxupload." KB in size.";}
	
	}
	
		else{
		$query = "UPDATE topics SET topic = '$topic', text = '$text'  WHERE topic_id = $topic_id";
		if (mysqli_query($dbc, $query)){
	$notification = "your topic has been updated";
	header ('Location: sportforums.php?topic='.$topic_id.'&category='.$category.'&n='.$notification.'');
			}
		}
	}else {$notification = "fields cannot be empty"; }
}

if (isset($_POST['submit2'])) {
    if ($_POST['confirm'] == 'Yes') {
  if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
	$topic = $_POST['topic_id'];
    $picture = $_POST['picture'];
	
	// DELETE the datas FROM the database
$query1 = "DELETE FROM topics_reply WHERE topic_id = $topic";
mysqli_query($dbc, $query1);

$query3 = "DELETE FROM following WHERE topic_id = $topic";
mysqli_query($dbc, $query3);
	
$query = "DELETE FROM topics WHERE topic_id = $topic LIMIT 1";

if( mysqli_query($dbc, $query)){
	if (!empty($picture)) {
	@unlink(GW_UPLOADPATH . $picture);
	}
	// Confirm success with the user
            $notification = "the topic has been deleted.";
	header ('Location: sportforums.php?category='.$category.'&n='.$notification.'');
	

	}else{ $notification = "error: could not delete the topic";}
}
}

  // Insert the page header
  $page_title = 'edit topic';
  require_once('header.php');

if (isset($notification)) {
if (!empty($notification)) {
echo'<p class="bg-warning">'.$notification.'</p>';
}
$notification = "";
exit();
}
?>

<?php
if (isset($_GET['topic']) >= 1){
echo ' 
<h4> edit your topic</h4>';

if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
$topic = $_GET['topic'];
  // Retrieve the data data from selected MySQL tables
  $query = "SELECT topic_id, topic, text, picture FROM topics WHERE topic_id = $topic ";
 $result = mysqli_query($dbc, $query);
 $row = mysqli_fetch_array($result);
	if ($row != NULL) {
	
    $text = $row['text'];

if (is_file(GW_UPLOADPATH . $row['picture']) && filesize(GW_UPLOADPATH . $row['picture']) > 0) {
      echo '<img src="' . GW_UPLOADPATH . $row['picture'] . '" class="img-responsive center-block"  alt="image" />';
    }
	echo '<br>';
  echo '<form enctype="multipart/form-data" method="post" action="edittopic.php?category='.$category.'">';
    echo '<input type="hidden" name="MAX_FILE_SIZE" value=" GW_MAXFILESIZE" />';
    echo'
    <div class="form-group">
    <label for="name">Topic:</label>
    <input class="form-control" type="text" id="topic" name="topic" value="'.$row['topic'].'" maxlength="100"/>
    </div>';
    echo '
    <div class="form-group">
    <label for="text">Text:</label>
    <textarea class="form-control" name="text" rows="20" cols="60">'.$row['text'].' </textarea>
    </div>';
    
    echo '<input type="hidden" name="topic_id" value="' .$row['topic_id'].'" />';
	echo '<input type="hidden" name="oldpicture" value="' .$row['picture']. '" />';
	  echo '<p> alter or add new picture... max '.$maxupload.' </p>';
	  echo '<label for="newpicture">new picture:</label>
    <input type="file" id="newpicture" name="newpicture" />';
	      echo '<input type="submit" value="update topic" name="submit" />';
  echo '</form>';
echo '<hr />';

    echo'<fieldset>';
	echo'<legend> Delete the Topic?? </legend>';
	echo'<p>select if you wish to delete this topic</p>';
	echo '<form method="post" action="edittopic.php?category='.$category.'">';
    echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
    echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
    echo '<input type="submit" value="delete" name="submit2" />';
    echo '<input type="hidden" name="topic_id" value="' .$row['topic_id'].'" />';
    echo '<input type="hidden" name="picture" value="' .$row['picture']. '" />';
    echo '</form>';
	echo'</fieldset>';
}
}else{
echo ' no topic is selected ';
}
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>