// Trigger each time user hear a song
const music = document.getElementById("playmusic");
music.volume = 0.1;
const song_id = location.search.split("song_id=")[1];

music.onplay = function(){
    // Lagu yg diputar
    
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200){
        const response = JSON.parse(xhr.responseText);
        // const response = 0;
        console.log(response);
        if (response >= 3){
            music.controls = false; 
        }
        }
    }
    xhr.open("POST", "/app/controller/play_lagu.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("&var=" + song_id);
    // "&song_id=" + song_id
}

music.onended = function(){
    
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200){
        const response = JSON.parse(xhr.responseText);
        
        if (response >= 3){
            music.controls = false;  
        } 
        }
    }
    xhr.open("POST", "/app/controller/play_lagu.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("&var=" + song_id + "&isEnded=true" );
}

