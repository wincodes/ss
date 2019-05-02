<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Insert the page header
  $page_title = 'Privacy Policy';
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
<h4 class="text-center"> Sport Socia Privacy Policy </h4>
  <p class="text-justify">When you use Sport Social network, you trust us with your information. This Privacy Policy is meant to help you understand what data we collect, why we collect it, and what we do with it.</p> <br />

<p class="text-justify">You can use our network to share information, to communicate with other people or to create new content. When you share your private information with us, for example by  creating an account, we only require basic  identification information like names, picture, email, location and birthdate which can be visible to other users when they click your profile. However, we do not require very sensitive information like credit or debit card pin, email passwords, home or office address, we do not require any form of online payment when you sign up.</p> <br />

<p class="text-justify">For legal reasons we will share personal information with companies, organizations or individuals outside of sport social if we believe that access or disclosure of the information is necessary to meet any applicable law, regulation, legal process or governmental policy which may include  violation of Terms of Service, investigation, prevention, or addressing  fraud issues, security  or technical issues as required or permitted by law. </p><br />

<p class="text-justify">When you log in we use cookies to store the log info locally on your device. You may also set your  browser to block all cookies, or to indicate when a cookie is set. However, it’s important to remember that this service will not function properly if your cookies are disabled.</p> <br />

<p class="text-justify">When you create a topic, an event, an update, or a comment, it is stored in our servers and  visible to all registered and non-registered users. It is therefore expected that no sensitive or very confidential info should be shared as Sport Socia will not be responsible for any loss or damages resulting from giving out these sensitive info. Also users are entirely responsible for their post, updates or comments. Thanks</p><br />

<?php
require_once('mobilesportnetworks.php');

?>
  
<?php
  // Insert the page footer
  require_once('footer.php');
?>
