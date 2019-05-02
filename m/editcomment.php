<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$category = $_GET['category'];
$topic_id = $_GET['topic'];

if (isset($_POST['submit'])) {
	if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
	
    $reply = mysqli_real_escape_string($dbc, trim($_POST['reply']));
	$reply_id = $_POST['reply_id'];
	
	if (!empty($reply) && !empty($reply_id)){
		
		$query = "UPDATE topics_reply SET reply = '$reply' WHERE reply_id = $reply_id";

			if( mysqli_query($dbc, $query)){
			$notification = "your comment has been updated";
			header ('Location: sportforums.php?topic='.$topic_id.'&category='.$category.'&n='.$notification.'');
				}else{
	$notification = "an error occurred while updating the topic";
	
		}
		} 
	else {$notification = "fields cannot be empty";
		}
		
	}


if (isset($_POST['submit2'])) {
    if ($_POST['confirm'] == 'Yes') {
  if (!isset($dbc)) {
require_once('connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
	$reply_id = $_POST['reply_id'];
    
	
	// DELETE the datas FROM the database
$query = "DELETE FROM topics_reply WHERE reply_id = $reply_id LIMIT 1";

if( mysqli_query($dbc, $query)){
	
	// Confirm success with the user
            $notification = "your comment has been deleted.";
	header ('Location: sportforums.php?topic='.$topic_id.'&category='.$category.'&n='.$notification.'');
	
	}else{ $notification = "error: could not delete the comment";}
}
}
  // Insert the page header
  $page_title = 'edit comment';
  require_once('header.php');

if (isset($_GET['n']) >= 1){
	$notification = $_GET['n'];
}
if (isset($notification)) {
if (!empty($notification)) {
echo'<p class="bg-warning">'.$notification.'</p>';
}
$notification = "";
exit();

}

?>

<?php
if (isset($_GET['reply_id']) >= 1){
echo ' 
<h4> edit your comment</h4>';

if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}
$reply_id = $_GET['reply_id'];
  // Retrieve the data data from selected MySQL tables
  $query = "SELECT reply FROM topics_reply WHERE reply_id = $reply_id ";
 $result = mysqli_query($dbc, $query);
 $row = mysqli_fetch_array($result);
	if ($row != NULL) {
	
    $reply = $row['reply'];

	
  echo '<form enctype="multipart/form-data" method="post" action="editcomment.php?topic='.$topic_id.'&category='.$category.'">';
    echo '<label for="reply">your comment:</label>
    <textarea name="reply" rows="20" cols="60">'.$row['reply'].' </textarea><br />';
    echo '<input type="hidden" name="reply_id" value="' .$reply_id.'" />';
    echo '<input type="submit" value="update comment" name="submit" />';
  echo '</form>';
  echo '<hr />';

    echo'<fieldset>';
	echo'<legend> Delete your comment?? </legend>';
	echo'<p>select if you wish to delete this comment</p>';
	echo '<form method="post" action="editcomment.php?topic='.$topic_id.'&category='.$category.'">';
    echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
    echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
    echo '<input type="submit" value="delete comment" name="submit2" />';
    echo '<input type="hidden" name="reply_id" value="' .$reply_id.'" />';
    echo '</form>';
	echo'</fieldset>';
}
}else{
echo ' <p class="bg-warning">no comment is selected </p>';
}
?>

<?php
  // Insert the page footer
  require_once('footer.php');
?>