document.onkeydown = function (event) {
  if (event.key === "Enter") {
    try {
      const element = document.querySelector("[contenteditable]");
      element.blur();
    } catch (e) {}
  }
};

function validateContent(element) {
  if (element.innerHTML.replace(/(?:&nbsp;|<br>)/g, "") == "") {
    let temp = element
      .getAttribute("prev-content")
      .replace(/(?:&nbsp;|<br>)/g, "");
    element.innerHTML = temp;
  }

  element.removeAttribute("contenteditable");
  element.removeAttribute("prev-content");
}

function edit(element) {
  const prevElement = element.previousElementSibling;
  prevElement.setAttribute("contenteditable", true);
  prevElement.setAttribute("prev-content", prevElement.innerHTML);
  prevElement.focus();
}

const image_input = document.querySelector("#image-input");

image_input.addEventListener("change", function () {
  const reader = new FileReader();
  reader.addEventListener("load", () => {
    const uploaded_image = reader.result;
    console.log(uploaded_image);
    document.querySelector("#album_img").src = `${uploaded_image}`;
  });
  reader.readAsDataURL(this.files[0]);
  console.log("tes", this.files[0]);
});

function removeSong(song_id) {
  element = document.querySelector("#song_" + song_id);

  if (element.classList.contains("deleted")) {
    element.classList.remove("deleted");
  } else {
    element.classList.add("deleted");
  }
}

function save() {
  const id = location.search.split("album_id=")[1];
  const judul = document.getElementById("album__judul").innerHTML.trim();
  const genre = document.getElementById("album__genre").innerHTML.trim();
  const tanggal = document.getElementById("album__tanggal-terbit").value;
  const img = document.getElementById("image-input").files;

  const deletedSongsId = [];

  const deletedSongs = document.getElementsByClassName("deleted");

  for (let i = 0; i < deletedSongs.length; i++) {
    deletedSongsId.push(deletedSongs[i].id.replace("song_", ""));
  }

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      if (xhr.responseText == 200) {
        // Success
        alert("Save album success!");
        location.reload();
      } else {
        // Failed
        alert("Save album fail!");
      }
      // Success
    } else if (xhr.readyState == 4 && xhr.status != 200) {
      // Failed
      alert("Save album fail!");
    }
  };

  const formData = new FormData();

  formData.append("id", id);
  formData.append("judul", judul);
  formData.append("genre", genre);
  formData.append("tanggal", tanggal);
  formData.append("file", img[0]);
  formData.append("deleteIds", JSON.stringify(deletedSongsId));

  xhr.open("POST", "./view/js/ajax/save_album.php", true);
  xhr.send(formData);
}

function deleteAlbum() {
  const id = location.search.split("album_id=")[1];

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);
      if (xhr.responseText == 200) {
        // Success
        alert("Delete album success!");
        location.replace("http://localhost:8008/index.php");
      } else {
        // Failed
        alert("Delete album fail!");
      }
    } else if (xhr.readyState == 4 && xhr.status != 200) {
      // Failed
      alert("Delete album fail!");
    }
  };

  const formData = new FormData();

  formData.append("id", id);

  xhr.open("POST", "./view/js/ajax/delete_album.php", true);
  xhr.send(formData);
}
