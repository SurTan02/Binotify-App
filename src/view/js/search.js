const __pagination = (page, total) => {
  let arr = Array.from({ length: total }, (_, i) => i + 1);
  if (total < 8) {
    // Do Nothing
  } else {
    const n = page - 1;
    if (n < 2) {
      arr[5] = "...";
      for (let i = 6; i < total - 1; i++) {
        arr[i] = "";
      }
    } else if (total - n <= 2) {
      arr[total - 6] = "...";
      for (let i = 1; i < total - 6; i++) {
        arr[i] = "";
      }
    } else {
      for (let i = 1; i < total - 1; i++) {
        if (
          n - 2 === i ||
          n - 1 === i ||
          n === i ||
          n + 1 === i ||
          n + 2 === i
        ) {
          // Do Nothing
        } else if (n - 3 === i && i >= 1) {
          arr[i] = "...";
        } else if (n + 3 === i && i <= total - 1) {
          arr[i] = "...";
        } else {
          arr[i] = "";
        }
      }
    }
  }
  return arr;
};

function loadSong(page = 1) {
  const urlParams = new URLSearchParams(window.location.search);

  const query = urlParams.get("query");
  const judul = urlParams.get("judul") ? urlParams.get("judul") : "";
  const tahun = urlParams.get("tahun") ? urlParams.get("tahun") : "";
  const genre = document.querySelector('input[name="genre"]:checked').value;

  let entries = urlParams.entries();
  let first = "";

  for (const [index, entry] of [...entries].entries()) {
    if (index === 1) {
      first = entry[0];
    }
  }

  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log(xhr.responseText);
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
        song_list += `<li class="list-song" onclick="window.location='/detail_lagu.php?song_id=${
          song.song_id
        }'">
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
      const pages = __pagination(page, total_page);

      if (page != 1) {
        pagination += `<li onclick="loadSong(${page - 1})">←</li>`;
      } else {
        pagination += `<li>←</li>`;
      }

      for (let i = 0; i < pages.length; i++) {
        if (pages[i] === "") {
        } else if (pages[i] === page) {
          pagination += `<li class="page-active">${pages[i]}</li>`;
        } else if (pages[i] === "...") {
          pagination += `<li>...</li>`;
        } else {
          pagination += `<li onclick="loadSong(${pages[i]})">${pages[i]}</li>`;
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
  xhr.send(
    "query=" +
      query +
      "&genre=" +
      genre +
      "&page=" +
      page +
      "&judul=" +
      judul +
      "&tahun=" +
      tahun +
      "&first=" +
      first
  );
}

const updateSortJudul = () => {
  const judul = document.getElementById("sort_judul").value;
  const url = new URL(window.location);

  if (judul === "") {
    document.getElementById("sort_judul_img").src =
      "./view/assets/img/judul_asc.png";
    document.getElementById("sort_judul").value = "ASC";
    url.searchParams.append("judul", "ASC");
  } else if (judul === "ASC") {
    document.getElementById("sort_judul_img").src =
      "./view/assets/img/judul_desc.png";
    document.getElementById("sort_judul").value = "DESC";
    url.searchParams.set("judul", "DESC");
  } else {
    document.getElementById("sort_judul_img").src =
      "./view/assets/img/judul.png";
    document.getElementById("sort_judul").value = "";
    url.searchParams.delete("judul");
  }

  window.history.replaceState({}, "", url);

  loadSong();
};

const updateSortTahun = () => {
  const tahun = document.getElementById("sort_tahun").value;
  const url = new URL(window.location);

  if (tahun === "") {
    document.getElementById("sort_tahun_img").src =
      "./view/assets/img/tahun_asc.png";
    document.getElementById("sort_tahun").value = "ASC";
    url.searchParams.append("tahun", "ASC");
  } else if (tahun === "ASC") {
    document.getElementById("sort_tahun_img").src =
      "./view/assets/img/tahun_desc.png";
    document.getElementById("sort_tahun").value = "DESC";
    url.searchParams.set("tahun", "DESC");
  } else if (tahun === "DESC") {
    document.getElementById("sort_tahun_img").src =
      "./view/assets/img/tahun.png";
    document.getElementById("sort_tahun").value = "";
    url.searchParams.delete("tahun");
  }

  window.history.replaceState({}, "", url);

  loadSong();
};

document.onload = loadSong();

const url = new URL(window.location);
url.searchParams.delete("judul");
url.searchParams.delete("tahun");
url.searchParams.set("judul", "ASC");
window.history.replaceState({}, "", url);
