<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    class Student {
        public $name;
        public $age;
        public $gender;
        public $posts;
        public function __construct($name, $age, $gender, $posts){
            $postsArray   = explode(",", $posts);
            $this->name   = $name;
            $this->age    = $age;
            $this->gender = $gender;
            $this->posts  = $postsArray;
        }
        public function getJsonObject() {
            return json_encode([
                "name" => $this->name,
                "age" => $this->age,
                "gender" => $this->gender,
                "posts" => $this->posts,
            ]);
        }
        public function saveJsonIntoArray($file,$newjsonData){
            // Check if the file exists
            if (file_exists($file)) {
                // File exists, so read its contents
                $oldjsonData = file_get_contents($file);
                if ($oldjsonData === false) {
                    // Failed to read the file
                    die('Failed to read the JSON file.');
                }
            } else {
                // File doesn't exist, so create it with empty JSON data
                $oldjsonData = '[]'; 
                // initialize it with an empty array 
                if (file_put_contents($file, $oldjsonData) === false) {
                    // Failed to create the file
                    die('Failed to create the JSON file.');
                }
            }
                // Convert the JSON data to a PHP associative array
                $collection = json_decode($oldjsonData, true);
                $newcollection = json_decode($newjsonData, true);

                //save the new JSON data into existing array
                $collection[] = $newcollection;

                // Save the updated data to the JSON file
                file_put_contents($file, json_encode($collection));
        }

    }
    $name       = $_POST["name"];
    $age        = $_POST["age"];
    $gender     = $_POST["gender"];
    $posts      = $_POST["posts"];
    $filename   = $_POST["filename"];
    $studobj = new Student($name, $age, $gender, $posts);
    $jsonData = $studobj->getJsonObject();
    $studobj->saveJsonIntoArray($filename,$jsonData);
}
?>

