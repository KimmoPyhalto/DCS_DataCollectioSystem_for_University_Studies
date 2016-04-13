<?php
// THIS FEATURE IS IN DEVELOPMENT
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  }
else
  {
  	$SavePath = ($_REQUEST["SavePath"]);
  	$SaveFolder = ($_REQUEST["SaveFolder"]);
  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
  echo "Type: " . $_FILES["file"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
  echo "id: " . $SavePath . "<br>";
  echo "Stored in: " . $_FILES["file"]["tmp_name"];
  
   if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      	
      mkdir("$SavePath$SaveFolder", 0700);
      	
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "$SavePath$SaveFolder/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
  
  }
?> 