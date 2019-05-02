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
