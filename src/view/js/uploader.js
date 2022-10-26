export async function uploadHandler(type) {
  return new Promise((resolve, reject) =>{
    if (type === "image"){
      var error_path = document.getElementById("error_image_path");
      var files = document.getElementById("image_path").files;
      var php_path = "view/js/ajax/upload_album.php";
    }else{
      var error_path = document.getElementById("error_audio_path");
      var files = document.getElementById("audio_path").files;
      var php_path = "view/js/ajax/upload_song.php";
    }
  
    if(files.length > 0 ){
        
       var formData = new FormData();
       formData.append("file", files[0]);
  
       var xhttp = new XMLHttpRequest();
       // Set POST method and ajax file path
       xhttp.open("POST", php_path, true);
  
       // call on request changes state
       var response;
       xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            response = this.responseText;
            error_path.innerHTML="";
            if(response == 1){
              
              // alert("Upload successfully.");
              resolve(response);
            } else if(response == 2){
              if (type === "image"){
                error_path.innerHTML="JPG, JPEG, PNG ONLY";
              } else{
                error_path.innerHTML="MP3, WAV ONLY";
              }
            } else{
              // alert("File not uploaded.");
            }
            
            return  response;
          }
       };
       // Send request with data
       xhttp.send(formData);
    }
  })
}