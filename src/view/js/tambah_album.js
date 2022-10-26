import {uploadHandler} from './uploader.js';

const element = document.getElementById('edit_form');
element.addEventListener('submit', async event => {
  event.preventDefault();
  
  let title = document.getElementById("title");
  let error_title = document.getElementById("error_title");
  error_title.innerHTML="";

  let penyanyi = document.getElementById("penyanyi");
  let error_penyanyi = document.getElementById("error_penyanyi");
  error_penyanyi.innerHTML="";

  let tanggal = document.getElementById("tanggal");
  let error_tanggal = document.getElementById("error_tanggal");
  error_tanggal.innerHTML="";

  let genre = document.getElementById("genre");
  let error_genre = document.getElementById("error_genre");
  error_genre.innerHTML="";

  let image_path = document.getElementById("image_path");
  let error_image_path = document.getElementById("error_image_path");
  error_image_path.innerHTML="";

  var isSafe = true;
  if (title.value === ''){
      error_title.innerHTML="Judul Album tidak boleh kosong";
      isSafe = false;
  }

    if (penyanyi.value === ''){
        error_penyanyi.innerHTML="Penyanyi tidak boleh kosong";
        isSafe = false;
    }

    if (genre.value === ''){
        error_genre.innerHTML="Genre tidak boleh kosong";
        isSafe = false;
    }

  if (tanggal.value === ''){
    error_tanggal.innerHTML="Tanggal tidak boleh kosong";
    isSafe = false;
  }
  if (image_path.files.length == 0){
    error_image_path.innerHTML="Gambar tidak boleh kosong";
    isSafe = false;
  } 
 

  if (isSafe){
    let response = await uploadHandler("image");
    if (response == 1){
        addAlbum();
    }
  }
    
});

function addAlbum(){
    const title = document.getElementById("title").value;
    const penyanyi = document.getElementById("penyanyi").value;
    const genre = document.getElementById("genre").value;
    const tanggal = document.getElementById("tanggal").value;
    const image_path = "/view/assets/img/" + document.getElementById("image_path").files[0].name;
    
    // console.log(duration, title,penyanyi,genre,album,tanggal,audio_path,image_path);

    if (title !== '' && tanggal !== '' && penyanyi !== '' && genre !== '' && image_path !== ''){
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200){
            const response = xhr.responseText;
            // const response = 0;
            console.log(response);
            if (response == 1){
              alert("Album berhasil ditambahkan");
            } else{
              alert("Album gagal ditambahkan");
            }
          }
        }
        xhr.open("POST", "./view/js/ajax/tambah_album.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(
        "title=" + title +
            "&penyanyi=" + penyanyi +
            "&genre=" + genre +
            "&tanggal=" + tanggal +
            "&image_path=" + image_path
        );
    }

    
}