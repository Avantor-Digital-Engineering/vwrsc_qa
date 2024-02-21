<!DOCTYPE html>
<html>
<head>
  <title>Upload your files</title>
</head>
<body>
  <form enctype="multipart/form-data" action="upload.php" method="POST">
    <p>Upload your file</p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
  </form>
</body>
</html>
<?PHP
  ini_set('error_reporting', E_ALL);
  if(!empty($_FILES['uploaded_file']))
  {
    
	$uploaddir = $_SERVER['DOCUMENT_ROOT']  .'/sites/default/files/docs_dropbox/34410';

	if(!is_dir($uploaddir)) {
		
		mkdir($uploaddir, 0777);
	} else {
		chmod($uploaddir, 0777);
	}
	  print_r($_FILES);
	 $result = move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploaddir.'/'. $_FILES['uploaded_file']['name']);
     if($result == 1){
		 echo "uploaded";
	 }
	 else{
		 echo "not uploaded";
	 }
	
	
    
  }
?>