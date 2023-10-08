<?php
$file = $_GET['filename'];
 if (file_exists($file)) {
    // File exists, so read its contents
    $jsonData = file_get_contents($file);
    if ($jsonData === false) {
        // Failed to read the file
        die('Failed to read the JSON file.');
    }else{
        echo $jsonData;
    }
} 
?>
