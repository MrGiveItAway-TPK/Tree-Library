<?php
echo $CustomPath=$_POST['MYCUSTOMPATH'];
$target_dir =__DIR__ . "/Files/$CustomPath/";
if (!is_dir($target_dir) && !mkdir($target_dir)){
  die("Error creating folder $target_dir");
}
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
	$Returnmessage = "File is not an image.";
	header('location:uploader.php?Rmessage='.$Returnmessage.'');
    $uploadOk = 0;
  }
}
if (file_exists($target_file)) {
  $Returnmessage = "Sorry, file already exists.";
	header('location:uploader.php?Rmessage='.$Returnmessage.'');
  $uploadOk = 0;
}
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $Returnmessage = "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
	header('location:uploader.php?Rmessage='.$Returnmessage.'');
  } else {
	$Returnmessage = "Sorry, there was an error uploading your file.";
	header('location:uploader.php?Rmessage='.$Returnmessage.'');
  }
}
?>