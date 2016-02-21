<?php
define("UPLOAD_DIR", "/var/www/uploads/");

print_r($_SERVER);
print_r($_FILES);



if (!empty($_FILES["IDMdatafile"])) {
	
	$myFile = $_FILES["IDMdatafile"];

	if ($myFile["error"] !== UPLOAD_ERR_OK) {
		echo "<p>An error occurred.</p>";
		exit;
	}
	
	print "<p>" . $myFile["name"] . "</p>";

	// ensure a safe filename
	//$name =  $myFile["name"];
	$name = preg_replace("/[^A-Z0-9._-]/i", "_", $myFile["name"]);

	// don't overwrite an existing file
	$i = 0;
	$parts = pathinfo($name);
	
	
	while (file_exists(UPLOAD_DIR . $name)) {
		$i++;
		
		$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
	}
		
	print "<p>Name of File on UNIX:" . $name . "</p>";

	// preserve file from temporary directory
	$success = move_uploaded_file($myFile["tmp_name"],UPLOAD_DIR . $name);
	
	if (!$success) {
		echo "<p>Unable to save file.</p>";
		exit;
	}

	// set proper permissions on the new file
	chmod(UPLOAD_DIR . $name, 0644);
}
else
{
	echo "<p>Empty</p>";
	exit;	
}

?>