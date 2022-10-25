import {uploadHandler} from './uploader.js';

let elems = document.getElementsByClassName("admin-only")
for (var i=0;i<elems.length;i+=1){
    elems[i].style.display = 'block';
}

const element = document.getElementById('edit_form');
element.addEventListener('submit', event => {
  event.preventDefault();
  // actual logic, e.g. validate the form
  let name = uploadHandler("image");
  // uploadHandler("image");
  let input_title = document.getElementById("edit_title");
  let input_penyanyi = document.getElementById("edit_penyanyi");
  let input_genre = document.getElementById("edit_genre");
  let input_tanggal = document.getElementById("edit_tanggal");
  let input_audio = document.getElementById("edit_audio_path");
  let input_image = document.getElementById("edit_image_path");

  // input_audio.value = "tes";
  console.log("iki", name);
  alert(name);
  
});

function editLagu(e){
  e.preventDefault();
  
}


// Get the modal
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];


btn.onclick = function() {
  modal.style.display = "block";
}
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
