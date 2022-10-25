export function uploadHandler(type) {
    if (type === "image"){
      var error_path = document.getElementById("error_edit_image_path");
    //   var files = document.getElementById("edit_image_path").files;
      var files = document.getElementById("edit_image_path").files;
      var php_path = "view/js/ajax/upload_album.php";
    }else{
      var error_path = document.getElementById("error_edit_audio_path");
      var files = document.getElementById("edit_audio_path").files;
      var php_path = "view/js/ajax/upload_song.php";
    }
  
    if(files.length > 0 ){
       var formData = new FormData();
       formData.append("file", files[0]);
  
       var xhttp = new XMLHttpRequest();
       // Set POST method and ajax file path
       xhttp.open("POST", php_path, true);
  
       // call on request changes state
       xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            
            if(response == 1){
            //   console.log(files[0].name);
            //   alert("Upload successfully.");
                
            } else if(response == 2){
              error_path.innerHTML="JPG, JPEG, PNG ONLY";
            } else{
              console.log(response);
              alert("File not uploaded.");
            }
          }
       };
       // Send request with data
       xhttp.send(formData);
       if (response == 1) return (files[0].name);
    }else{
       alert("Please select a file");
    }
  
  }