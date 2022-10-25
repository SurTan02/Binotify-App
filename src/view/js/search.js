function loadSong(page = 1) {
  const query = location.search.split("query=")[1];
  const genre = document.querySelector('input[name="genre"]:checked').value;

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);

      const start = Math.min((page - 1) * 10 + 1, response.count);
      document.getElementById(
        "songs-pagination-information"
      ).innerHTML = `Showing results <b>${start}-${Math.min(
        page * 10,
        response.count
      )}</b> of <b>${response.count}</b>`;

      let song_list = "";
      response.data.forEach((song, idx) => {
        song_list += `<li class="list-song">
          <div class="song">
            <span>${start + idx}</span>
            <img class="song-image" src="${song.image_path}" />
            <div class="song-information1">
              <span class="song-title">${song.judul}</span>
              <span class="song-genre">${song.genre}</span>
            </div>
            <div class="song-information2">
              <span class="song-author">${song.penyanyi}</span>
              <span class="song-year">${song.tanggal_terbit.substring(
                0,
                4
              )}</span>
            </div>
          </div>
        </li>`;
      });
      document.getElementById("songs-list").innerHTML = song_list;

      let pagination = "";
      const total_page = Math.ceil(response.count / 10);
      if (page != 1) {
        pagination += `<li onclick="loadSong(${page - 1})">←</li>`;
      } else {
        pagination += `<li>←</li>`;
      }

      for (let i = 1; i <= total_page; i++) {
        if (page == i) {
          pagination += `<li class="page-active" onclick="loadSong(${i})">${i}</li>`;
        } else {
          pagination += `<li onclick="loadSong(${i})">${i}</li>`;
        }
      }

      if (page != total_page) {
        pagination += `<li onclick="loadSong(${page + 1})">→</li>`;
      } else {
        pagination += `<li>→</li>`;
      }

      document.getElementById("songs-pagination-pages").innerHTML = pagination;
    }
  };

  xhr.open("POST", "./view/js/ajax/search.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("query=" + query + "&genre=" + genre + "&page=" + page);
}
