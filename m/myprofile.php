<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }

    // Connect to the database
  	if (!isset($dbc)) {
require_once('../connectvars.php');
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
}

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
    $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
    $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
    $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
    $state = mysqli_real_escape_string($dbc, trim($_POST['state']));
	$country = mysqli_real_escape_string($dbc, trim($_POST['country']));
	$fav_sports = mysqli_real_escape_string($dbc, trim($_POST['fav_sports']));
    $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
    $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
    $new_picture_type = $_FILES['new_picture']['type'];
    $new_picture_size = $_FILES['new_picture']['size']; 
    
    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {
      if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
        ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= GW_MAXFILESIZE)) 
			{
        if ($_FILES['new_picture']['error'] == 0) {
          // Move the file to the target upload folder
          $target = GW_UPLOADPATH . basename($new_picture);
          if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
            // The new picture file move was successful, now make sure any old picture is deleted
            if (!empty($old_picture) && ($old_picture != $new_picture)) {
              @unlink(GW_UPLOADPATH . $old_picture);
            }
          }
          else {
            // The new picture file move failed, so delete the temporary file and set the error flag
            @unlink($_FILES['new_picture']['tmp_name']);
          
            $notification = 'Sorry, there was a problem uploading your picture.';
          }
        }
      }
      else {
        // The new picture file is not valid, so delete the temporary file and set the error flag
        @unlink($_FILES['new_picture']['tmp_name']);
        $notification = 'Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (GW_MAXFILESIZE / 1024) .
          ' KB ';
      }
    }

    // Update the profile data in the database
    
      if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate) && !empty($city) && !empty($state) && !empty($country) ) {
        // Only set the picture column if there is a new picture
        if (!empty($new_picture)) {
          $query = "UPDATE ss_user SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', " .
            " birthdate = '$birthdate', city = '$city', state = '$state', country = '$country', fav_sports = '$fav_sports', picture = '$new_picture' WHERE user_id = '" . $_SESSION['user_id'] . "'";
        }
        else {
          $query = "UPDATE ss_user SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', " .
            " birthdate = '$birthdate', city = '$city', state = '$state', country = '$country', fav_sports = '$fav_sports' WHERE user_id = '" . $_SESSION['user_id'] . "'";
        }
        mysqli_query($dbc, $query);

        // Confirm success with the user
        $notification = 'Your profile has been successfully updated.';

            }
      else {
        $notification = 'You must enter all of the profile data (the picture is optional).';
      }
 } // End of check for form submission
    
  // Insert the page header
  $page_title = 'My Profile';
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


if (isset($_GET['view']) && $_GET['view']== 'edit' ){
    // Grab the profile data from the database
    $query = "SELECT first_name, last_name, gender, birthdate, city, fav_sports, state, country, picture FROM ss_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $gender = $row['gender'];
      $birthdate = $row['birthdate'];
      $city = $row['city'];
      $state = $row['state'];
	  $country = $row['country'];
      $old_picture = $row['picture'];
    }
    else {
      echo '<p class="error">There was a problem accessing your profile.</p>';
    exit;
	}

echo'  <form enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
echo '<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />';
echo '<fieldset>';
echo '<legend>Profile Data</legend>';
if (!empty($old_picture)) {
        echo '<img class="profile" src="' . GW_UPLOADPATH . $old_picture . '" width = "70%" " alt="Profile Picture" /><br />';
      }
echo ' <label for="new_picture">Change Picture: (max '.$maxupload.')</label>
      <input type="file" id="new_picture" name="new_picture" /><br />';
 echo'<div class="form-group">';
 echo '<label for="firstname">First name:</label>
<input type="text" id="firstname" name="firstname" maxlength="32" value="' .$row['first_name']. '" /></div>';
echo'<div class="form-group">';
echo '      <label for="lastname">Last name:</label>
<input type="text" id="lastname" name="lastname" maxlength="32" value="' .$row['last_name']. '" /></div>';
echo'<div class="form-group">';
echo ' <label for="gender">Gender:</label>';
echo '  <select id="gender" name="gender">';
echo '  <option value="M" if (!empty(' .$row['gender']. ') && $gender == "M") echo "selected = "selected""; >Male</option>';
echo '   <option value="F"  if (!empty(' .$row['gender']. ') && $gender == "F") echo "selected = "selected""; >Female</option>';
echo '  </select></div>';
echo'<div class="form-group">';
echo ' <label for="birthdate">Birthdate:</label>
      <input type="text" id="birthdate" name="birthdate" maxlength="10" value="' .$row['birthdate']. '" /></div>';
echo'<div class="form-group">';
echo '<label for="city">City:</label>
      <input type="text" id="city" name="city" maxlength="32" value="' .$row['city']. '" /></div>';
echo'<div class="form-group">';
echo '<label for="state">State:</label>
      <input type="text" id="state" name="state" maxlength="32" value="' .$row['state']. '" /></div>';
echo'<div class="form-group">';
echo' <label for="country">country:</label>
	<select id="country" name="country">
		<option value="'.$country.'";">'.$country.'</option> 
		 <option value="Afghanistan">Afghanistan</option> 
 <option value="Albania">Albania</option>
  <option value="Algeria">Algeria</option>
  <option value="American Samoa">American Samoa</option> 
  <option value="Andorra">Andorra</option> 
  <option value="Angola">Angola</option> 
  <option value="Anguilla">Anguilla</option> 
  <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> 
  <option value="Argentina">Argentina</option> 
  <option value="Armenia">Armenia</option> 
  <option value="Aruba">Aruba</option> 
  <option value="Australia">Australia</option> 
  <option value="Austria">Austria</option> 
  <option value="Azerbaijan">Azerbaijan</option> 
  <option value="Bahamas">Bahamas</option> 
  <option value="Bahrain">Bahrain</option> 
  <option value="Bangladesh">Bangladesh</option> 
  <option value="Barbados">Barbados</option> 
  <option value="Belarus">Belarus</option> 
  <option value="Belgium">Belgium</option> 
  <option value="Belize">Belize</option> 
  <option value="Benin">Benin</option> 
  <option value="Bermuda">Bermuda</option> 
  <option value="Bhutan">Bhutan</option> 
  <option value="Bolivia">Bolivia</option> 
  <option value="Bonaire">Bonaire</option> 
  <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> 
  <option value="Botswana">Botswana</option> 
  <option value="Brazil">Brazil</option> 
  <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> 
  <option value="Brunei">Brunei</option> 
  <option value="Bulgaria">Bulgaria</option> 
  <option value="Burkina Faso">Burkina Faso</option> 
  <option value="Burundi">Burundi</option> 
  <option value="Cambodia">Cambodia</option> 
  <option value="Cameroon">Cameroon</option> 
  <option value="Canada">Canada</option> 
  <option value="Canary Islands">Canary Islands</option> 
  <option value="Cape Verde">Cape Verde</option> 
  <option value="Cayman Islands">Cayman Islands</option> 
  <option value="Central African Republic">Central African Republic</option> 
  <option value="Chad">Chad</option> 
  <option value="Channel Islands">Channel Islands</option> 
  <option value="Chile">Chile</option> 
  <option value="China">China</option> 
  <option value="Christmas Island">Christmas Island</option> 
  <option value="Cocos Island">Cocos Island</option> 
  <option value="Colombia">Colombia</option> 
  <option value="Comoros">Comoros</option> 
  <option value="Congo">Congo</option> 
  <option value="Cook Islands">Cook Islands</option> 
  <option value="Costa Rica">Costa Rica</option> 
  <option value="Cote D’Ivoire">Cote D’Ivoire</option> 
  <option value="Croatia">Croatia</option> 
  <option value="Cuba">Cuba</option> 
  <option value="Curacao">Curacao</option> 
  <option value="Cyprus">Cyprus</option> 
  <option value="Czech Republic">Czech Republic</option> 
  <option value="Denmark">Denmark</option> 
  <option value="Djibouti">Djibouti</option> 
  <option value="Dominica">Dominica</option> 
  <option value="Dominican Republic">Dominican Republic</option> 
  <option value="East Timor">East Timor</option> 
  <option value="Ecuador">Ecuador</option> 
  <option value="Egypt">Egypt</option> 
  <option value="El Salvador">El Salvador</option> 
  <option value="Equatorial Guinea">Equatorial Guinea</option> 
  <option value="Eritrea">Eritrea</option> 
  <option value="Estonia">Estonia</option> 
  <option value="Ethiopia">Ethiopia</option> 
  <option value="Falkland Islands">Falkland Islands</option> 
  <option value="Faroe Islands">Faroe Islands</option> 
  <option value="Fiji">Fiji</option> 
  <option value="Finland">Finland</option> 
  <option value="France">France</option> 
  <option value="French Guiana">French Guiana</option> 
  <option value="French Polynesia">French Polynesia</option> 
  <option value="French Southern Ter">French Southern Ter</option> 
  <option value="Gabon">Gabon</option> 
  <option value="Gambia">Gambia</option> 
  <option value="Georgia">Georgia</option> 
  <option value="Germany">Germany</option> 
  <option value="Ghana">Ghana</option> 
  <option value="Gibraltar">Gibraltar</option> 
  <option value="Great Britain">Great Britain</option> 
  <option value="Greece">Greece</option> 
  <option value="Greenland">Greenland</option> 
  <option value="Grenada">Grenada</option> 
  <option value="Guadeloupe">Guadeloupe</option> 
  <option value="Guam">Guam</option> 
  <option value="Guatemala">Guatemala</option> 
  <option value="Guinea">Guinea</option> 
  <option value="Guyana">Guyana</option> 
  <option value="Haiti">Haiti</option> 
  <option value="Hawaii">Hawaii</option> 
  <option value="Honduras">Honduras</option> 
  <option value="Hong Kong">Hong Kong</option> 
  <option value="Hungary">Hungary</option> 
  <option value="Iceland">Iceland</option> 
  <option value="India">India</option> 
  <option value="Indonesia">Indonesia</option> 
  <option value="Iran">Iran</option> 
  <option value="Iraq">Iraq</option> 
  <option value="Ireland">Ireland</option> 
  <option value="Isle of Man">Isle of Man</option> 
  <option value="Israel">Israel</option> 
  <option value="Italy">Italy</option> 
  <option value="Jamaica">Jamaica</option> 
  <option value="Japan">Japan</option> 
  <option value="Jordan">Jordan</option> 
  <option value="Kazakhstan">Kazakhstan</option> 
  <option value="Kenya">Kenya</option> 
  <option value="Kiribati">Kiribati</option> 
  <option value="Korea North">Korea North</option> 
  <option value="Korea South">Korea South</option> 
  <option value="Kuwait">Kuwait</option> 
  <option value="Kyrgyzstan">Kyrgyzstan</option> 
  <option value="Laos">Laos</option> 
  <option value="Latvia">Latvia</option> 
  <option value="Lebanon">Lebanon</option> 
  <option value="Lesotho">Lesotho</option> 
  <option value="Liberia">Liberia</option> 
  <option value="Libya">Libya</option> 
  <option value="Liechtenstein">Liechtenstein</option> 
  <option value="Lithuania">Lithuania</option> 
  <option value="Luxembourg">Luxembourg</option> 
  <option value="Macau">Macau</option> 
  <option value="Macedonia">Macedonia</option> 
  <option value="Madagascar">Madagascar</option> 
  <option value="Malaysia">Malaysia</option> 
  <option value="Malawi">Malawi</option> 
  <option value="Maldives">Maldives</option> 
  <option value="Mali">Mali</option> 
  <option value="Malta">Malta</option> 
  <option value="Marshall Islands">Marshall Islands</option> 
  <option value="Martinique">Martinique</option> 
  <option value="Mauritania">Mauritania</option> 
  <option value="Mauritius">Mauritius</option> 
  <option value="Mayotte">Mayotte</option> 
  <option value="Mexico">Mexico</option> 
  <option value="Midway Islands">Midway Islands</option> 
  <option value="Moldova">Moldova</option> 
  <option value="Monaco">Monaco</option> 
  <option value="Mongolia">Mongolia</option> 
  <option value="Montserrat">Montserrat</option> 
  <option value="Morocco">Morocco</option> 
  <option value="Mozambique">Mozambique</option> 
  <option value="Myanmar">Myanmar</option> 
  <option value="Namibia">Namibia</option> 
  <option value="Nauru">Nauru</option> 
  <option value="Nepal">Nepal</option> 
  <option value="Netherland Antilles">Netherland Antilles</option> 
  <option value="Netherlands">Netherlands (Holland, Europe)</option> 
  <option value="Nevis">Nevis</option> 
  <option value="New Caledonia">New Caledonia</option> 
  <option value="New Zealand">New Zealand</option> 
  <option value="Nicaragua">Nicaragua</option> 
  <option value="Niger">Niger</option> 
  <option value="Nigeria">Nigeria</option> 
  <option value="Niue">Niue</option> 
  <option value="Norfolk Island">Norfolk Island</option> 
  <option value="Norway">Norway</option> 
  <option value="Oman">Oman</option> 
  <option value="Pakistan">Pakistan</option> 
  <option value="Palau Island">Palau Island</option> 
  <option value="Palestine">Palestine</option> 
  <option value="Panama">Panama</option> 
  <option value="Papua New Guinea">Papua New Guinea</option> 
  <option value="Paraguay">Paraguay</option> 
  <option value="Peru">Peru</option> 
  <option value="Philippines">Philippines</option> 
  <option value="Pitcairn Island">Pitcairn Island</option> 
  <option value="Poland">Poland</option> 
  <option value="Portugal">Portugal</option> 
  <option value="Puerto Rico">Puerto Rico</option> 
  <option value="Qatar">Qatar</option> 
  <option value="Republic of Montenegro">Republic of Montenegro</option> 
  <option value="Republic of Serbia">Republic of Serbia</option> 
  <option value="Reunion">Reunion</option> 
  <option value="Romania">Romania</option> 
  <option value="Russia">Russia</option> 
  <option value="Rwanda">Rwanda</option> 
  <option value="St Barthelemy">St Barthelemy</option> 
  <option value="St Eustatius">St Eustatius</option> 
  <option value="St Helena">St Helena</option> 
  <option value="St Kitts-Nevis">St Kitts-Nevis</option> 
  <option value="St Lucia">St Lucia</option> 
  <option value="St Maarten">St Maarten</option> 
  <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> 
  <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> 
  <option value="Saipan">Saipan</option> 
  <option value="Samoa">Samoa</option> 
  <option value="Samoa American">Samoa American</option> 
  <option value="San Marino">San Marino</option> 
  <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> 
  <option value="Saudi Arabia">Saudi Arabia</option> 
  <option value="Senegal">Senegal</option> 
  <option value="Serbia">Serbia</option> 
  <option value="Seychelles">Seychelles</option> 
  <option value="Sierra Leone">Sierra Leone</option> 
  <option value="Singapore">Singapore</option> 
  <option value="Slovakia">Slovakia</option> 
  <option value="Slovenia">Slovenia</option> 
  <option value="Solomon Islands">Solomon Islands</option> 
  <option value="Somalia">Somalia</option> 
  <option value="South Africa">South Africa</option> 
  <option value="Spain">Spain</option> 
  <option value="Sri Lanka">Sri Lanka</option> 
  <option value="Sudan">Sudan</option> 
  <option value="Suriname">Suriname</option> 
  <option value="Swaziland">Swaziland</option> 
  <option value="Sweden">Sweden</option> 
  <option value="Switzerland">Switzerland</option> 
  <option value="Syria">Syria</option> 
  <option value="Tahiti">Tahiti</option> 
  <option value="Taiwan">Taiwan</option> 
  <option value="Tajikistan">Tajikistan</option> 
  <option value="Tanzania">Tanzania</option> 
  <option value="Thailand">Thailand</option> 
  <option value="Togo">Togo</option> 
  <option value="Tokelau">Tokelau</option> 
  <option value="Tonga">Tonga</option> 
  <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> 
  <option value="Tunisia">Tunisia</option> 
  <option value="Turkey">Turkey</option> 
  <option value="Turkmenistan">Turkmenistan</option> 
  <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> 
  <option value="Tuvalu">Tuvalu</option> 
  <option value="Uganda">Uganda</option> 
  <option value="Ukraine">Ukraine</option> 
  <option value="United Arab Emirates">United Arab Emirates</option> 
  <option value="United Kingdom">United Kingdom</option> 
  <option value="United States of America">United States of America</option> 
  <option value="Uruguay">Uruguay</option> 
  <option value="Uzbekistan">Uzbekistan</option> 
  <option value="Vanuatu">Vanuatu</option> 
  <option value="Vatican City State">Vatican City State</option> 
  <option value="Venezuela">Venezuela</option> 
  <option value="Vietnam">Vietnam</option> 
  <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> 
  <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> 
  <option value="Wake Island">Wake Island</option> 
  <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> 
  <option value="Yemen">Yemen</option> 
  <option value="Zaire">Zaire</option> 
  <option value="Zambia">Zambia</option> 
  <option value="Zimbabwe">Zimbabwe</option> 
  </select><br />
	
';
echo'<div class="form-group">';
echo '<label for="favourite sport">favourite sport:</label>
      <input type="text" id="fav_sports" name="fav_sports" maxlength="99" value="' .$row['fav_sports']. '" /></div>';
echo '<input type="hidden" name="old_picture" value="' .$row['picture']. '" />';
echo '<input type="submit" value="Save" name="submit" />';
echo '  </fieldset>';
echo '  </form>';

}else{

  // Grab the profile data from the database
 $query = "SELECT username, first_name, last_name, gender, birthdate, city, state, country, email, fav_sports, picture FROM ss_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
  $data = mysqli_query($dbc, $query);

  if (mysqli_num_rows($data) == 1) {
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);
    if (!empty($row['picture'])) {
      echo '<img src="' . GW_UPLOADPATH . $row['picture'] .
        '" class="img-responsive center-block" alt="Profile Picture" />';
    }

    echo '<table class="table">';
	if (!empty($row['username'])) {
      echo '<tr><td>Username:</td><td>' . $row['username'] . '</td></tr>';
    }
    if (!empty($row['first_name'])) {
      echo '<tr><td>First name:</td><td>' . $row['first_name'] . '</td></tr>';
    }
    if (!empty($row['last_name'])) {
      echo '<tr><td>Last name:</td><td>' . $row['last_name'] . '</td></tr>';
    }
    if (!empty($row['gender'])) {
      echo '<tr><td>Gender:</td><td>';
      if ($row['gender'] == 'M') {
        echo 'Male';
      }
      else if ($row['gender'] == 'F') {
        echo 'Female';
      }
	   echo '</td></tr>';
    }
    if (!empty($row['birthdate'])) {
        // Show the user their own birthdate
        echo '<tr><td>Birthdate:</td><td>' . $row['birthdate'] . '</td></tr>';
      
    }
    if (!empty($row['city']) || !empty($row['state'])) {
      echo '<tr><td>Location:</td><td>' . $row['city'] . ', ' . $row['state'] . ', ' . $row['country'] . '</td></tr>';
    }
     if (!empty($row['email'])) {
        
        echo '<tr><td>e-mail:</td><td>' . $row['email'] . '</td></tr>';
	 }
	 if (!empty($row['fav_sports'])) {
        
        echo '<tr><td>favourite sports:</td><td>' . $row['fav_sports'] . '</td></tr>';
      
    }
    echo '</table>';
  } // End of check for a single row of user results
  else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
    }
echo " <a href='{$_SERVER['PHP_SELF']}?view=edit'> edit profile </a> " ;

}
?>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
