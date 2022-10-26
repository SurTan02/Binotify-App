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

function loadUsers(page = 1) {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);

      const start = Math.min((page - 1) * 10 + 1, response.count);
      document.getElementById("users-pagination-information").innerHTML = `Showing results <b>${start}-${Math.min(page * 10, response.count)}</b> of <b>${response.count}</b>`;

      let user_list = "";
      response.data.forEach((user, idx) => {
        if (user.isadmin === false) {
          role = "User";
        }
        else {
          role = "Admin";
        }
        user_list += `<li class="list-user">
          <div class="user" >
            <div class="user-information">
              <span>${start + idx}</span>
              <div class="user-id">${user.user_id}</div>
              <div class="username">${user.username}</div>
              <div class="user-email">${user.email}</div>
              <div class="user-role">${role}</div>
            </div>
          </div>
        </li > `;
      });
      document.getElementById("users-list").innerHTML = user_list;

      let pagination = "";
      const total_page = Math.ceil(response.count / 10);
      const pages = __pagination(page, total_page);

      if (page != 1) {
        pagination += `< li onclick = "loadUsers(${page - 1})" ><< /li>`;
      }
      else {
        pagination += `<li>←</li>`;
      }

      for (let i = 0; i < pages.length; i++) {
        if (pages[i] === "") {

        }
        else if (pages[i] === page) {
          pagination += `<li class="page-active">${pages[i]}</li>`;
        }
        else if (pages[i] === "...") {
          pagination += `<li>...</li>`;
        }
        else {
          pagination += `<li onclick="loadUsers(${pages[i]})">${pages[i]}</li>`;
        }
      }

      if (page != total_page) {
        pagination += `<li onclick="loadUsers(${page + 1})">></li>`;
      }
      else {
        pagination += `<li>→</li>`;
      }

      document.getElementById("users-pagination-pages").innerHTML = pagination;
    }
  };

  xhr.open("POST", "./view/js/ajax/daftar_user.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("&page=" + page);
}

document.onload = loadUsers();