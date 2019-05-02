<?php
   // Start the session
  require_once('../startsession.php');
  // Insert the upload path and connectction details
  require_once('uploadpath.php');
require_once('../connectvars.php');
 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
  $firstname = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
  $lastname = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
  $gender = mysqli_real_escape_string($dbc, trim($_POST['gender']));
  $birthdate = mysqli_real_escape_string($dbc, trim($_POST['birthdate']));
  $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
  $state = mysqli_real_escape_string($dbc, trim($_POST['state']));
  $country = mysqli_real_escape_string($dbc, trim($_POST['country']));
  $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
  $fav_sports = mysqli_real_escape_string($dbc, trim($_POST['fav_sports']));
  
  
    if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
      // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM ss_user WHERE username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO ss_user ( username, password, join_date, first_name, last_name, gender, birthdate, city, state, country, email, fav_sports) VALUES ('$username', SHA('$password1'), NOW(), '$firstname', '$lastname', '$gender', '$birthdate', '$city', '$state', '$country', '$email', '$fav_sports')";
        if(mysqli_query($dbc, $query)){
        // Confirm success with the user
          $notification = 'Your account has been successfully created.';
	echo '<script type="text/javascript">
	window.location = "login.php?n=Your account has been successfully created please login"
	</script>
	';
          		} 
    else {
      $notification = 'an error occurred while creating your account please try again';
      }

        mysqli_close($dbc);
        exit();
      }
      else {
        // An account already exists for this username, so display an error message
      $notification = 'An account already exists for this username. Please choose a different username.';
        $username = "";
      }
    }
    else {
      $notification = 'You must enter all of the sign-up data, including your desired password twice.';
    }
  }


  // Insert the page header
   $page_title = 'Sign Up';
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
<?php
if (isset($_SESSION['user_id'])) {
  echo'<p class="bg-warning">you are already logged in</p>';
	exit();
}
?>
  <p>Please fill this form to create your Sport Social account.</p>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <fieldset>
      <div id="heading"><legend>Registration Info</legend></div><br />
      <label for="username">Username:</label>
  <input type="text" id="username" name="username" maxlength="32" onblur="validateNonEmpty(this, document.getElementById('user_help'))" 
      value="<?php if (!empty($username)) echo $username; ?>" />
      <span id="user_help" style="color:#F00" class="help"></span><br />
     
      <label for="password1">Password:</label>
      <input type="password" id="password1" maxlength="20" name="password1" 
      onblur="validateNonEmpty(this, document.getElementById('pass1_help'))"/>
      <span id="pass1_help" style="color:#F00" class="help"></span><br />
     
      <label for="password2">Password (retype):</label>
      <input type="password" id="password2" maxlength="20" name="password2" 
      onblur="validatePassword(this, document.getElementById('pass2_help'))"/>
      <span id="pass2_help" style="color:#F00" class="help"></span><br />
   
    <label for="firstname">First name:</label>
      <input type="text" id="firstname" name="firstname" maxlength="32" 
      onblur="validateNonEmpty(this, document.getElementById('firstname_help'))"
      value="<?php if (!empty($firstname)) echo $firstname; ?>"maxlength="32" />
      <span id="firstname_help" style="color:#F00" class="help"></span><br />
   
    <label for="lastname">Last name:</label>
    <input type="text" id="lastname" name="lastname" maxlength="32" 
    onblur="validateNonEmpty(this, document.getElementById('lastname_help'))"
    value="<?php if (!empty($lastname)) echo $lastname; ?>"maxlength="32" />
    <span id="lastname_help" style="color:#F00" class="help"></span><br />
  
  <label for="gender">Gender:</label>
    <select id="gender" name="gender">
      <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
        <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
      </select><br />
    <br>

       <label for="birthdate">Birthdate: <p class="help-block"> Example: 1990-12-01 <p></label>
      <input type="text" id="birthdate" name="birthdate" maxlength="10"
      onblur="validateNonEmpty(this, document.getElementById('date_help'))"
      value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" />
      <span id="date_help" style="color:#F00" class="help"></span><br />
      <br>
       
      <label for="city">City:</label>
      <input type="text" id="city" name="city" maxlength="32" 
      onblur="validateNonEmpty(this, document.getElementById('city_help'))"
      value="<?php if (!empty($city)) echo $city; ?>"maxlength="32" />
      <span id="city_help" style="color:#F00" class="help"></span><br />
	
    <label for="state">State:</label>
      <input type="text" id="state" name="state" maxlength="32" 
      onblur="validateNonEmpty(this, document.getElementById('state_help'))"
      value="<?php if (!empty($state)) echo $state; ?>"maxlength="10" />
      <span id="state_help" style="color:#F00" class="help"></span><br />

<label for="country">Country:</label>
  <select id="country" name="country"> 
 <option value="">select country</option> 
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
 
      <label for="email">Email:</label>
      <input type="text" id="email" name="email" maxlength="50" 
      onblur="validateNonEmpty(this, document.getElementById('mail_help'))"
      value="<?php if (!empty($email)) echo $email; ?>"maxlength="50" />
      <span id="mail_help" style="color:#F00" class="help"></span><br />

	<label for="fav_sports">Favorite Sports:</label>
      <input type="text" id="fav_sports" name="fav_sports" maxlength="99" value="<?php if (!empty($fav_sports)) echo $fav_sports; ?>"maxlength="100" /><br />      
       </fieldset>
	<p> By clicking sign up, you agree to sport socia <a href="terms.php">terms of use</a></p> 
    <input type="submit" id="submit" value="Sign Up" name="submit" />
  </form>
  
<script type="text/javascript">
// JavaScript Document 
function validateNonEmpty(inputField, helpText) {
       // See if the input value contains any text
        if (inputField.value.length == 0) {
          // The data is invalid, so set the help message
          if (helpText != null)
            helpText.innerHTML = "Please enter a value.";
          return false;
        }
        else {
          // The data is OK, so clear the help message
          if (helpText != null)
            helpText.innerHTML = "";
          return true;
        }
      }
function validatePassword(inputField, helpText) {
       // See if the input value contains any text
        if (inputField.value.length == 0) {
          // The data is invalid, so set the help message
          if (helpText != null)
            helpText.innerHTML = "Please enter a value.";
          return false;
        }
        else {
          // data was entered, so check if passwords match
          var password1 = document.getElementById("password1").value;
        	var password2 = document.getElementById("password2").value;
		  if (password1==password2){
		  if (helpText != null)
            helpText.innerHTML = "";
          return true;
		  }else{
			  if (helpText != null)
            helpText.innerHTML = "Passwords don't match.";
          return false;
		  }
		}
      }

</script>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
