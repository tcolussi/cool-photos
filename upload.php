<?php
	//------------------------------- Start edit here ---------------------------------//

	$maxlimit = 9048576; // Max image limit
	$folder = "fb_images"; // Folder where to save images
	
	// Requirements
	$minwidth = 390; // Min width
	$minheight = 100; // Min height
	$maxwidth = 3000; // Max width
	$maxheight = 3000; // Max height
	
	// Allowed extensions
	$extensions = array('.png', '.gif', '.jpg', '.jpeg','.PNG', '.GIF', '.JPG', '.JPEG');
	
	//------------------------------- End edit here -----------------------------------//

	// Check that we have a file
	if((!empty($_FILES["uploadfile"])) && ($_FILES['uploadfile']['error'] == 0)) {

	// Check extension
	$extension = strrchr($_FILES['uploadfile']['name'], '.');
	if (!in_array($extension, $extensions))	{
		echo '<p class="error">Wrong file format, alowed only .png , .gif, .jpg, .jpeg</p>
		<script language="javascript" type="text/javascript">window.top.window.formEnable();</script>';
	} else {

	// Get file size
	$filesize = $_FILES['uploadfile']['size'];

	// Check file size
	if($filesize > $maxlimit){ 
		echo '<p class="error">File size is too big.</p>';
	} else if($filesize < 1){ 
		echo '<p class="error">File size is empty.</p>';
	} else {

	// Temporary file
	$uploadedfile = $_FILES['uploadfile']['tmp_name'];

	// Capture the original size of the uploaded image
	list($width,$height) = getimagesize($uploadedfile);

	// Check if image size is lower
	if($width < $minwidth || $height < $minheight){ 
		echo '<p class="error">Image is to small. Required minimum '.$minwidth.' x '.$minheight.'</p>
		<script language="javascript" type="text/javascript">window.top.window.formEnable();</script>';
	} else if($width > $maxwidth || $height > $maxheight){ 
		echo '<p class="error">Image is to big. Required maximum '.$maxwidth.' x '.$maxheight.'</p>
		<script language="javascript" type="text/javascript">window.top.window.formEnable();</script>';
	} else {

	// All characters lowercase
	$filename = strtolower($_FILES['uploadfile']['name']);
	
	// Replace all spaces with _
	$filename = preg_replace('/\s/', '_', $filename);
	
	// Extract filename and extension
	$pos = strrpos($filename, '.'); 
	$basename = substr($filename, 0, $pos); 
	$ext = substr($filename, $pos+1);

	// Get random number
	$rand = time();

	// Image name
	$image = $_POST['uploaded_photo']. "." . $ext;

	// Create an image from it so we can do the resize
	switch($ext){
	  case "gif":
		$src = imagecreatefromgif($uploadedfile);
	  break;
	  case "jpg":
		$src = imagecreatefromjpeg($uploadedfile);
	  break;
	  case "jpeg":
		$src = imagecreatefromjpeg($uploadedfile);
	  break;
	  case "png":
		$src = imagecreatefrompng($uploadedfile);
	  break;
	}

	// Create thumbnail image
	$newheight = ($height/$width)*390;
	$newwidth = 390;
	$tmp=imagecreatetruecolor($newwidth,$newheight);
	imagealphablending($tmp, false);
	imagesavealpha($tmp,true);
	imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

	// Write thumbnail to disk
	$write_thumb = $folder .'/'. $image;
	switch($ext){
	  case "gif":
		imagegif($tmp,$write_thumb);
	  break;
	  case "jpg":
		imagejpeg($tmp,$write_thumb,100);
	  break;
	  case "jpeg":
		imagejpeg($tmp,$write_thumb,100);
	  break;
	  case "png":
		imagepng($tmp,$write_thumb);
	  break;
	}

	// Clean temporary files
	imagedestroy($src);
	imagedestroy($tmp);

	// Image preview
	echo '<img id="preview" src="' . $write_thumb . '" alt="Preview Picture" width="'. $newwidth .'" />
	<script language="javascript" type="text/javascript">window.parent.window.photoLoaded();</script>';

      }
    }
  }
}
?>