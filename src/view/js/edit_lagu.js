import {uploadHandler} from './uploader.js';

let elems = document.getElementsByClassName("admin-only")
for (var i=0;i<elems.length;i+=1){
    elems[i].style.display = 'block';
}

// Get the modal
var edit_modal = document.getElementById("edit_modal");
var delete_modal = document.getElementById("delete_modal");
var edit_btn = document.getElementById("edit_button");
var delete_btn = document.getElementById("delete_button");
var no_delete = document.getElementById("no_delete");
var span = document.getElementsByClassName("close")[0];


edit_btn.onclick = function() {
  edit_modal.style.display = "block";
}

delete_btn.onclick = function() {
  delete_modal.style.display = "block";
}

no_delete.onclick = function() {
  delete_modal.style.display = "none";
}
span.onclick = function() {
  edit_modal.style.display = "none";
  delete_modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == delete_modal || event.target == edit_modal) {
    edit_modal.style.display = "none";
    delete_modal.style.display = "none";
  }
}


const element = document.getElementById('edit_form');
element.addEventListener('submit', async event => {
  event.preventDefault();
  
  let title = document.getElementById("title");
  let error_title = document.getElementById("error_title");
  error_title.innerHTML="";

  let tanggal = document.getElementById("tanggal");
  let error_tanggal = document.getElementById("error_tanggal");
  error_tanggal.innerHTML="";

  let audio_path = document.getElementById("audio_path");
  let error_audio_path = document.getElementById("error_audio_path");
  error_audio_path.innerHTML="";

  let image_path = document.getElementById("image_path");
  let error_image_path = document.getElementById("error_image_path");
  error_image_path.innerHTML="";

  var isSafe = true;
  if (title.value === ''){
      error_title.innerHTML="Judul Lagu tidak boleh kosong";
      isSafe = false;
  }
  if (tanggal.value === ''){
    error_tanggal.innerHTML="Tanggal tidak boleh kosong";
    isSafe = false;
  }

  if (isSafe){
    var audio_response = 0;
    if (audio_path.files.length > 0){
      audio_response = await uploadHandler("audio");
    }
    var image_response = 0;
    if (image_path.files.length > 0){
      image_response = await uploadHandler("image");
      console.log("ahghagah" , image_response)
    }

    if (audio_response == 1){
      var au = document.createElement('audio');
      au.src = "/view/assets/song/" + audio_path.files[0].name;
      au.addEventListener('loadedmetadata', function(){
        editSong(parseInt(au.duration), audio_response, image_response);
      });
    } 
    
    else{
      editSong(0, 0 , image_response);
    }
    
  }
    
});


function editSong(duration = 0, audio_response = 0, image_response = 0){
  const song_id = location.search.split("song_id=")[1];
  const title = document.getElementById("title").value;
  const genre = document.getElementById("genre").value;
  const album = document.getElementById("album").value;
  const tanggal = document.getElementById("tanggal").value;
  let audio_path ="";
  let image_path ="";

  if (audio_response == 1){
    audio_path = "/view/assets/song/" + document.getElementById("audio_path").files[0].name;
  }
  if (image_response == 1){
    image_path = "/view/assets/img/" + document.getElementById("image_path").files[0].name;
  }
  console.log("response");
  if (title !== '' && tanggal !== ''){
      let xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200){
          const response = xhr.responseText;
          // const response = 0;
          console.log(response);
          if (response == 1){
            alert("Lagu berhasil diedit");
            document.location.reload(true);
          } else{
            alert("Lagu gagal diedit");
          }
        }
      }
      xhr.open("POST", "/view/js/ajax/edit_lagu.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send(
      "title=" + title +
          "&genre=" + genre +
          "&album=" + album +
          "&tanggal=" + tanggal +
          "&audio_path=" + audio_path +
          "&image_path=" + image_path +
          "&song_id=" + song_id +
          "&duration=" + duration
      );
  }
}

const delete_button = document.getElementById('yes_delete');
delete_button.addEventListener('click', function(){
  const song_id = location.search.split("song_id=")[1];
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200){
        const response = xhr.responseText;
        if (response == 1){
          alert("Lagu berhasil dihapus");
          document.location.reload(true);
          location.href = 'http://localhost:8008/';
        } else{
          alert("Lagu gagal dihapus");
        }
      }
    }
    xhr.open("POST", "./view/js/ajax/delete_lagu.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("&song_id=" + song_id);
})

