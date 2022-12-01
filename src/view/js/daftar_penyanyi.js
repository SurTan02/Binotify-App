function sendSubscriptionRequest(creator_id) {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log(xhr.responseText);
      console.log("success");
      document.getElementById("subscribe-button-" + creator_id).innerHTML = "Pending";
      document.getElementById("subscribe-button-" + creator_id).disabled = true;
      document.getElementById("subscribe-button-" + creator_id).style.backgroundColor = "#f5a623";
    }
  }

  xhr.open("POST", "./view/js/ajax/daftar_penyanyi.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("creator_id=" + creator_id);
}


