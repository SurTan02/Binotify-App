// Trigger each time user hear a song
const music = document.getElementById("playmusic");
music.volume = 0.1;

music.onplay = function(){
    // Lagu yg diputar
    const song_id = location.search.split("song_id=")[1];
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200){
        const response = JSON.parse(xhr.responseText);
        // const response = 0;
        console.log(response);
        if (response > 3){
            
            // alert("Album berhasil ditambahkan");
        } else{
            // alert("Album gagal ditambahkan");
        }
        }
    }
    xhr.open("POST", "/app/controller/play_lagu.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("&var=" + song_id);
    // "&song_id=" + song_id
    
}

