// Global variable for checking if there are invalid input
const isInputValid = {
  "username": false,
  "password": false,
};

let input_username = document.getElementById("username");
let input_password = document.getElementById("password");
let error_username = document.getElementById("error_username");
let error_password = document.getElementById("error_password");

input_username.addEventListener("focusout", function () {
  //check if username label leave empty
  if (input_username.value == '') {
    input_username.style.backgroundColor = "#FFB4C7";
    error_username.innerHTML = "Username must not be empty";
    isInputValid["username"] = false;
  }
  else {
    input_username.style.backgroundColor = "#A5FFD4";
    error_username.innerHTML = "";
    isInputValid["username"] = true;
  }
});

input_password.addEventListener("focusout", function () {
  //check if username label leave empty
  if (input_password.value == '') {
    input_password.style.backgroundColor = "#FFB4C7";
    error_password.innerHTML = "Password must not be empty";
    isInputValid["password"] = false;
  }
  else {
    input_password.style.backgroundColor = "#A5FFD4";
    error_password.innerHTML = "";
    isInputValid["password"] = true;
  }
});

function validateInput() {
  for (const key in isInputValid) {
    if (isInputValid[key] === false) {
      return false;
    }
  }
  return true;
}