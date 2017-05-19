<?php
$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf","PDF", "doc", "xls", "docx","xlsx","zip","rar", "txt");

//$temp = explode(".", $_FILES["file"]["name"]);
//$extension = end($temp);

//if (in_array($extension, $allowedExts))
 // {
//  if ($_FILES["file"]["error"] > 0)
   // {
   // echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	//return "Error";
   // }
 // else
  //  {
   /* echo "Upload: " . $_FILES["uploadedfile1"]["name"] . "<br>";
    echo "Type: " . $_FILES["uploadedfile1"]["type"] . "<br>";
    echo "Size: " . ($_FILES["uploadedfile1"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["uploadedfile1"]["tmp_name"] . "<br>";  */
  $t="file has been uploaded successfully";
  $dirname=$_POST["docketnum12"];

  if (file_exists("C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname)) {
   	$uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname . "/";
   
    
   
} else {
   
    $uploadpath="C:/project/zend/Apache2/htdocs/osahcms/public/upload/".$dirname;
	mkdir($uploadpath);
	
	$uploadpath=$uploadpath . "/";
}
if (isset($_FILES['file']))
 {	
 	
 	$num_files = count($_FILES["file"]["name"]);
 	
 	
 	print_r($_FILES);
 	/** loop through the array of files ***/
 	//for($i=0; $i < $num_files;$i++)
 	//{
 	
 $t1=$_FILES["file"]["name"][0];

  //  if (file_exists( $uploadpath . $t1))
    //  {
    // $t=$_FILES["file"]["name"] . " already exists. ";
	// return $t;
     // }
   // else
      {
        move_uploaded_file($_FILES["file"]["tmp_name"][0],$uploadpath . $t1);
    //  echo "Stored in: " . "upload/" . $_FILES["uploadedfile1"]["name"];
      }
	  $t="/upload/" .$dirname . "/" . $t1;
 	
	  
}
return $t;
   //echo $t;
 
//else
 // {
  /* echo "Invalid file";  */ 
 // $t="Invalid File";
 // return $t;
 // }
?> 