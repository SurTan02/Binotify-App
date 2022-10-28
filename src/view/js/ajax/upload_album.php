<?php
function upload(){
    if(isset($_FILES['file']['name'])){
        // file name
        $filename = $_FILES['file']['name'];
    
        // Location
        $location = $_SERVER['DOCUMENT_ROOT']. '/view/assets/img/' .$filename;
    
        // file extension
        $file_extension = pathinfo($location, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
    
        // Valid extensions
        $valid_ext = array("jpg","png","jpeg"); 
        $response = 0;
       
        if(in_array($file_extension, $valid_ext)){
            
            // Upload file
            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                $response = 1;
            } 
        } else{
            //Extension Not Valid
            $response = 2; 
        }
    
        echo $response;
        exit;
        }
}
// call function
upload();
?>