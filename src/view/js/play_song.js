const audio_1 = document.getElementsByTagName("audio").item(0);
const audio_placeholder = document.getElementById("playmusic");

function myFunction(judul, url){
    audio_placeholder.src ="http://localhost:8080/" + url;
    audio_1.load();
}