

const inputValidationStatus = {
  username: false,
  email: false,
  password: false,
};

// function to validate form input
function validateInput() {
  for (let key in inputValidationStatus) {
    if (inputValidationStatus[key] === false) {
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
  xhr.open("GET", "./view/js/ajax/register.php?username=" + input_username.value, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = xhr.responseText;
      // check username is valid using regex
      if (input_username.value.match(/^[a-zA-Z0-9]+$/)) {
        inputValidationStatus.username = true;
        input_username.style.backgroundColor = "#00ff00";
        error_username.innerHTML = "";
      }
      else {
        inputValidationStatus.username = false;
        input_username.style.backgroundColor = "#ff0000";
        error_username.innerHTML = "Username must contain only letters and numbers";
      }
      if (response == "true") {
        inputValidationStatus.username = true;
        input_username.style.backgroundColor = "#00ff00";
        error_username.innerHTML = "";
      } else {
        inputValidationStatus.username = false;
        input_username.style.backgroundColor = "#ff0000";
        error_username.innerHTML = "Username already taken";
      }
    }
  }
  xhr.send();
});

// add event listener to the email input
let input_email = document.getElementById("email");
let error_email = document.getElementById("error_email");

input_email.addEventListener("change", function () {
  // using ajax to check if the email is already taken
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "./view/js/ajax/register.php?email=" + input_email.value, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = xhr.responseText;
      if (response == "true") {
        inputValidationStatus.email = true;
        input_email.style.backgroundColor = "#00ff00";
        error_email.innerHTML = "";
      } else {
        inputValidationStatus.email = false;
        input_email.style.backgroundColor = "#ff0000";
        error_email.innerHTML = "Email already taken";
      }

      // check email is valid using regex
      let regex = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
      if (regex.test(email)) {
        inputValidationStatus.email = true;
        input_email.style.backgroundColor = "#00ff00";
        error_email.innerHTML = "";
      }
      else {
        inputValidationStatus.email = false;
        input_email.style.backgroundColor = "#ff0000";
        error_email.innerHTML = "Email is invalid";
      }
    }
  }
  xhr.send();
});

// add event listener to the password input to check if the password is valid and if the password and confirm password match
let input_password = document.getElementById("password");
let input_confirm_password = document.getElementById("password_confirm");
let error_password = document.getElementById("error_password");
let error_confirm_password = document.getElementById("error_password_confirm");

input_password.addEventListener("change", function () {
  // check password is valid using regex
  let password = input_password.value;
  let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
  if (regex.test(password)) {
    inputValidationStatus.password = true;
    input_password.style.backgroundColor = "#00ff00";
    error_password.innerHTML = "";
  }
  else {
    inputValidationStatus.password = false;
    input_password.style.backgroundColor = "#ff0000";
    error_password.innerHTML = "Password must be at least 8 characters long and contain at least 1 uppercase letter, 1 lowercase letter and 1 number";
  }

  // check if the password and confirm password match
  if (password == input_confirm_password.value) {
    inputValidationStatus.password = true;
    input_password.style.borderColor = "#00ff00";
    error_password.innerHTML = "";
    input_confirm_password.style.borderColor = "#00ff00";
    error_confirm_password.innerHTML = "";
  }
  else {
    inputValidationStatus.password = false;
    input_password.style.borderColor = "#ff0000";
    error_password.innerHTML = "Passwords do not match";
    error_password.style.fontFamily = "Inter";
    error_password.style.fontSize = "12px";
    error_password.style.fontStyle = "oblique";

    input_confirm_password.style.borderColor = "#ff0000";
    error_confirm_password.innerHTML = "Passwords do not match";
    error_confirm_password.style.fontFamily = "Inter";
    error_confirm_password.style.fontSize = "12px";
    error_confirm_password.style.fontStyle = "oblique";
  }
});
