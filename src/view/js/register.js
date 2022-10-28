/**
 * init isInputValid object
 * 
 */
const isInputValid = {
  "username": false,
  "email": false,
  "password": false,
};

// create debounce function
const debounce = (func, delay) => {
  let inDebounce;
  return function () {
    const context = this;
    const args = arguments;
    clearTimeout(inDebounce);
    inDebounce = setTimeout(() => func.apply(context, args), delay);
  };
};


/**
 * using ajax to send the data to the server to validate is the username is valid and manipulate the DOM
 */

let input_username = document.getElementById("username");
let error_username = document.getElementById("error_username");
input_username.addEventListener("change", debounce(function () {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = xhr.responseText;
      let nameRegex = /^[a-zA-Z0-9_]+$/;
      if (nameRegex.test(input_username.value)) {
        isInputValid["username"] = true;
        input_username.style.borderColor = "#00ff00";
        error_username.innerHTML = "";
        if (response == "true") {
          isInputValid["username"] = true;
          input_username.style.borderColor = "#00ff00";
          error_username.innerHTML = "";
          validateInput();
        } else {
          isInputValid["username"] = false;
          input_username.style.borderColor = "#ff0000";
          error_username.innerHTML = "Username already taken";
          error_username.style.color = "#ff0000";
          error_username.style.fontFamily = "inter";
          error_username.style.fontSize = "12px";
          error_username.style.fontStyle = "oblique";
          validateInput();
        }
      }
      else {
        isInputValid["username"] = false;
        input_username.style.borderColor = "#ff0000";
        error_username.innerHTML = "Username must contain only letters, numbers and underscore";
        error_username.style.color = "#ff0000";
        error_username.style.fontFamily = "inter";
        error_username.style.fontSize = "12px";
        error_username.style.fontStyle = "oblique";
        validateInput();
      }
    }
  }
  xhr.open("GET", "./view/js/ajax/register.php?username=" + input_username.value, true);
  xhr.send();
}, 0));


/**
 * using ajax to send the data to the server to validate is the email is valid and manipulate the DOM
 *  
 */
let input_email = document.getElementById("email");
let error_email = document.getElementById("error_email");
input_email.addEventListener("change", debounce(function () {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      let response = xhr.responseText;
      let emailRegex = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
      if (emailRegex.test(input_email.value)) {
        isInputValid["email"] = true;
        input_email.style.borderColor = "#00ff00";
        error_email.innerHTML = "";
        if (response == "true") {
          isInputValid["email"] = true;
          input_email.style.borderColor = "#00ff00";
          error_email.innerHTML = "";
          validateInput();
        } else {
          isInputValid["email"] = false;
          input_email.style.borderColor = "#ff0000";
          error_email.innerHTML = "Email already taken.";
          error_email.style.fontFamily = "inter";
          error_email.style.fontSize = "12px";
          error_email.style.fontStyle = "italic";
          validateInput();
        }
      }
      else {
        isInputValid["email"] = false;
        input_email.style.borderColor = "#ff0000";
        error_email.innerHTML = "Email is not valid.";
        error_email.style.fontFamily = "inter";
        error_email.style.fontSize = "12px";
        error_email.style.fontStyle = "italic";
        validateInput();

      }
    }
  }


  xhr.open("GET", "./view/js/ajax/register.php?email=" + input_email.value, true);
  xhr.send();
}, 0));

/**
 * validate is the password same as the confirm password and manipulate the DOM
 * 
 */
let input_password = document.getElementById("password");
let input_password_confirm = document.getElementById("password_confirm");
let error_password = document.getElementById("error_password");
let error_password_confirm = document.getElementById("error_password_confirm");
input_password_confirm.addEventListener("change", debounce(function () {
  let same = false;
  if (input_password_confirm.value === input_password.value) {
    same = true;
    input_password.style.borderColor = "#00ff00";
    input_password_confirm.style.borderColor = "#00ff00";
    error_password_confirm.innerHTML = "";
    isInputValid["password"] = true;
    validateInput();

  }
  else {
    input_password.style.borderColor = "#ff0000";
    input_password_confirm.style.borderColor = "#ff0000";
    error_password_confirm.innerHTML = "Passwords do not match";
    error_password_confirm.style.fontFamily = "Inter";
    error_password_confirm.style.fontSize = "12px";
    error_password_confirm.style.fontStyle = "oblique";
    isInputValid["password"] = false;
    validateInput();


  }


}, 0));


/**
 * validateInpit is a function that validates the input of the user is valid
 * 
 * @returns {boolean} true if all inputs are valid
 */
function validateInput() {
  console.log("ngecek is input valid");
  let status = true;
  for (const key in isInputValid) {
    if (isInputValid[key] === false) {
      status = false;
    }
  }
  let submit_button = document.getElementById("register_button");
  status ? submit_button.disabled = false : submit_button.disabled = true;
}
