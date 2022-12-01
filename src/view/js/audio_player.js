const audio_1 = document.getElementById("music-playing-audio")
const audio_placeholder = document.getElementById("music-playing");
const song_title = document.getElementById("music-playing-title");
const all_play_button = document.getElementsByName("song-play-button");
const music_control_button = document.getElementById("music-control-play");
const progressBar  = document.getElementById('progress-bar');
const progressText  = document.getElementById('progress-text');

let current_song_id;
audio_1.volume = 0.5;

function playAnySong(judul, url, id){
    const song_play_button = all_play_button.item(id-1);
    current_song_id = id-1;
    song_title.innerHTML = judul;

    if (song_play_button.classList.contains("play-button")){
        song_play_button.classList.remove("play-button");

        all_play_button.forEach(element => {
            element.src ="./view/assets/img/play.svg";         
        });
        song_play_button.src = "./view/assets/img/pause.svg";


        if (audio_placeholder.src !=="http://localhost:8080/" + url){
            audio_placeholder.src = "http://localhost:8080/" + url;
            audio_1.load();
        }
        audio_1.play();

        // audio_1.addEventListener('ontimeupdate', updateProgressBar(), false)

    }else{
        song_play_button.classList.add("play-button");
        song_play_button.src = "./view/assets/img/play.svg"

        audio_1.pause();
    }

    music_control_button.src = song_play_button.src
}

function playingControl(){
    const song_play_button = all_play_button.item(current_song_id);
    
    if (music_control_button.classList.contains("play-button")){
        music_control_button.classList.remove("play-button");
        music_control_button.src = "./view/assets/img/pause.svg";
        audio_1.play();

        

    }else{
        music_control_button.classList.add("play-button");
        music_control_button.src = "./view/assets/img/play.svg"
        audio_1.pause();
        // console.log(music_control_button);
    }
    song_play_button.src = music_control_button.src;
}

window.onload = function(){
    // audio_1.addEventListener('timeupdate', updateProgressBar(), false)
    audio_1.ontimeupdate = function(){
        try {
            var percentage = Math.floor((100 / audio_1.duration) * audio_1.currentTime);
            progressBar.value = percentage;
            progressText.innerHTML = Math.floor(audio_1.currentTime) + " : " + Math.floor(audio_1.duration)
        } catch (error) {
        }
    }
    progressBar.onclick = function(e){
        if (music_control_button.src !== '') {
            var percent = e.offsetX / this.offsetWidth;
            
            audio_1.currentTime = percent * audio_1.duration;
            e.target.value = Math.floor(percent / 100);
            e.target.innerHTML = progressBar.value + '% played';
        }
    }
}
