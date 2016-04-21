<?php
$upload_path = 'files/';
 if(!is_writable($upload_path))
 {
 	die('You cannot upload to the specified directory');
 }
 else {
 	echo 'path writable'.nl2br("\n");
 }
$filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).

$tmpfileName = $_FILES['userfile']['tmp_name'];

if(move_uploaded_file($tmpfileName,$upload_path . $filename))
         echo 'Your file upload was successful, view the file <a href="' . $upload_path . $filename . '" title="Your File">here</a>'; // It worked.
      else
         echo 'There was an error during the file upload.  Please try again.'; 

/*we use this temp file name copy data from one place to another, i would like to change this to a temp folder of my choice*/ 
?>