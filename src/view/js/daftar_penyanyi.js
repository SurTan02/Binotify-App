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

// function loadSubscription(){
// }

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    var response = JSON.parse(this.responseText);
    console.log(response);
  }
};


xhttp.open("POST", "./view/js/ajax/daftar_penyanyi.php", true);
xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
let id_user_send = 1;
xhttp.send("&id_user=" + id_user_send);



async function loadPenyanyi(page = 1) {
  var id_user;
  await fetch("http://localhost:8008/data.php")
    .then((res) => res.json())
    .then((data) => {
      id_user = data.id_user;
    });
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // console.log("id_user", id_user);
      const response = JSON.parse(xhr.responseText);
      console.log(response);
      const start = Math.min((page - 1) * 10 + 1, response.count);
      document.getElementById(
        "singers-pagination-information"
      ).innerHTML = `Showing results <b>${start}-${Math.min(
        page * 10,
        response.count
      )}</b> of <b>${response.count}</b>`;

      let singer_list = "";
      response.forEach((singer, idx) => {
        singer_list += `<li class="list-singer" onclick="window.location='/detail_album.php?album_id=${singer.user_id
          }'">
          <div class="singer">
            <span>${start + idx}</span>
            <div class="singer-information1">
              <span class="singer-title">${singer.name}</span>
            </div>
            <script type="text/javascript">
              var myvar='<?php echo $idUser;?>';
              console.log(myvar);
            </script>
            <button class="subscribe-button">Subscribe</button>
          </div>
        </li>`;
      });
      document.getElementById("singers-list").innerHTML = singer_list;

      let pagination = "";
      const total_page = Math.ceil(response.count / 10);
      const pages = __pagination(page, total_page);

      if (page != 1) {
        pagination += `<li onclick="loadPenyanyi(${page - 1})">←</li>`;
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
          pagination += `<li onclick="loadPenyanyi(${pages[i]})">${pages[i]}</li>`;
        }
      }

      if (page != total_page) {
        pagination += `<li onclick="loadPenyanyi(${page + 1})">→</li>`;
      } else {
        pagination += `<li>→</li>`;
      }

      document.getElementById("singers-pagination-pages").innerHTML = pagination;
    }
  };

  xhr.open("GET", "http://localhost:8080/user?page=" + page, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // xhr.send("&page=" + page);
  xhr.send();
}

document.onload = loadPenyanyi();
