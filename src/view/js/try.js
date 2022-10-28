
document.getElementById("username").addEventListener("change", myFunction);

function myFunction() {
  var x = document.getElementById("username");
  x.value = x.value.toUpperCase();
}
