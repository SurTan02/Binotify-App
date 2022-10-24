
const isInputValid = {
  "username": false,
  "email": false,
  "password": false,
};

// function to validate form input
function validateInput() {
  for (let key in isInputValid) {
    if (isInputValid[key] === false) {
      return false;
    }
  }
  return true;
}

// add event listener to the username input
let input_username = document.getElementById("username");
let error_username = document.getElementById("error_username");

input_username.addEventListener("change", function () {
  // using ajax to check if the username is already taken
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = xhr.responseText;
      // check username is valid using regex
      if (response == "true") {
        isInputValid["username"] = true;
        input_username.style.borderColor = "#00ff00";
        error_username.innerHTML = "";
      } else {
        isInputValid["username"] = false;
        input_username.style.borderColor = "#ff0000";
        error_username.innerHTML = "Username already taken";
      }
      let nameRegex = /^[a-zA-Z0-9_]+$/;
      if (nameRegex.test(input_username.value)) {
        isInputValid["username"] = true;
        input_username.style.borderColor = "#00ff00";
        error_username.innerHTML = "";
      }
      else {
        isInputValid.username = false;
        input_username.style.borderColor = "#ff0000";
        error_username.innerHTML = "Username must contain only letters and numbers";
        error_username.style.color = "#ff0000";
        error_username.style.fontFamily = "inter";
        error_username.style.fontSize = "12px";
        error_username.style.fontStyle = "oblique";
      }
    }
  }
  xhr.open("GET", "./view/js/ajax/register.php?username=" + input_username.value, true);
  xhr.send();
});

// add event listener to the email input
let input_email = document.getElementById("email");
let error_email = document.getElementById("error_email");

input_email.addEventListener("change", function () {
  // using ajax to check if the email is already taken
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = xhr.responseText;
      if (response == "true") {
        isInputValid["email"] = true;
        input_email.style.borderColor = "#00ff00";
        error_email.innerHTML = "";
      } else {
        isInputValid["email"] = false;
        input_email.style.borderColor = "#ff0000";
        error_email.innerHTML = "Email is not valid.";
        error_email.style.fontFamily = "inter";
        error_email.style.fontSize = "12px";
        error_email.style.fontStyle = "italic";
      }
    }
  }
  xhr.open("GET", "./view/js/ajax/register.php?email=" + input_email.value, true);
  xhr.send();
});

// add event listener to the password input to check if the password is valid and if the password and confirm password match
let input_password = document.getElementById("password");
let input_password_confirm = document.getElementById("password_confirm");
let error_password = document.getElementById("error_password");
let error_password_confirm = document.getElementById("error_password_confirm");

input_password_confirm.addEventListener("change", function () {
  ;


  // Check if the input_password_confirm and input_password are the same.
  let same = false;
  if (input_password_confirm.value === input_password.value) {
    same = true;
    input_password.style.borderColor = "#00ff00";
    input_password_confirm.style.borderColor = "#00ff00";
    error_password_confirm.innerHTML = "";
    isInputValid["password"] = true;
  }
  else {
    input_password.style.borderColor = "#ff0000";
    input_password_confirm.style.borderColor = "#ff0000";
    error_password_confirm.innerHTML = "Passwords do not match";
    error_password_confirm.style.fontFamily = "Inter";
    error_password_confirm.style.fontSize = "12px";
    error_password_confirm.style.fontStyle = "oblique";
  }

});
