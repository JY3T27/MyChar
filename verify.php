<?php 
$target_dir = "assets/docs/uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
if ($check !== false || strtolower(pathinfo($target_file, PATHINFO_EXTENSION)) == 'pdf') {
    $uploadOk = 1;
} else {
    echo "File is not a valid image or PDF.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        // Call the Python script to process the uploaded file
        $command = escapeshellcmd("python verification.py " . escapeshellarg($target_file));
        $output = shell_exec($command);
        sleep(10);
        echo "Output from Python: " . $output;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>