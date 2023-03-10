import { uploadHandler } from "./uploader.js";

const element = document.getElementById("edit_form");
element.addEventListener("submit", async (event) => {
  event.preventDefault();

  let title = document.getElementById("title");
  let error_title = document.getElementById("error_title");
  error_title.innerHTML = "";

  let tanggal = document.getElementById("tanggal");
  let error_tanggal = document.getElementById("error_tanggal");
  error_tanggal.innerHTML = "";

  let audio_path = document.getElementById("audio_path");
  let error_audio_path = document.getElementById("error_audio_path");
  error_audio_path.innerHTML = "";

  let image_path = document.getElementById("image_path");
  let error_image_path = document.getElementById("error_image_path");
  error_image_path.innerHTML = "";

  var isSafe = true;
  if (title.value === "") {
    error_title.innerHTML = "Judul Lagu tidak boleh kosong";
    isSafe = false;
  }
  if (tanggal.value === "") {
    error_tanggal.innerHTML = "Tanggal tidak boleh kosong";
    isSafe = false;
  }

  if (audio_path.files.length == 0) {
    error_audio_path.innerHTML = "Audio tidak boleh kosong";
    isSafe = false;
  }

  if (isSafe) {
    let image_response = 1;
    let has_image = 0;


    if (image_path.files.length != 0){
      image_response = await uploadHandler("image");
      has_image = 1;
    }
    let audio_response = await uploadHandler("audio");
    if (image_response == 1 && audio_response == 1) {
      var au = document.createElement("audio");
      au.src = "/view/assets/song/" + audio_path.files[0].name;
      au.addEventListener('loadedmetadata', function () {
        addSong(parseInt(au.duration), has_image);
      });
    }
  }
});

function addSong(duration, has_image) {
  const title = document.getElementById("title").value;
  const penyanyi = document.getElementById("penyanyi").value;
  const genre = document.getElementById("genre").value;
  const tanggal = document.getElementById("tanggal").value;
  let image_path ='';
  const audio_path = "/view/assets/song/" + document.getElementById("audio_path").files[0].name;
  if (has_image){
    image_path = "/view/assets/img/" + document.getElementById("image_path").files[0].name;
  }

  // console.log(duration, title,penyanyi,genre,album,tanggal,audio_path,image_path);

  if (title !== "" && tanggal !== "" && duration !== "" && audio_path !== "") {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        const response = xhr.responseText;
        // const response = 0;
        console.log(response);
        if (response == 1) {
          alert("Lagu berhasil ditambahkan");
          document.location.reload(true);
        } else {
          alert("Lagu gagal ditambahkan");
        }
      }
    };
    xhr.open("POST", "./view/js/ajax/tambah_lagu.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(
      "title=" +
        title +
        "&penyanyi=" +
        penyanyi +
        "&genre=" +
        genre +
        "&tanggal=" +
        tanggal +
        "&audio_path=" +
        audio_path +
        "&image_path=" +
        image_path +
        "&duration=" +
        duration
    );
  }
}
