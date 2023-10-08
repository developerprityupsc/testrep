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
        public function saveJsonIntoArray($file){
            //store the data into an array
            $studentarr = [
                "name"   =>  $this->name,
                "age"    =>  $this->age,
                "gender" =>  $this->gender,
                "posts"  =>  $this->posts,
            ];

            //$file = 'data.json';
            // Check if the file exists
            if (file_exists($file)) {
                // File exists, so read its contents
                $jsonData = file_get_contents($file);
                if ($jsonData === false) {
                    // Failed to read the file
                    die('Failed to read the JSON file.');
                }
            } else {
                // File doesn't exist, so create it with empty JSON data
                $jsonData = '[]'; 
                // initialize it with an empty array 
                if (file_put_contents($file, $jsonData) === false) {
                    // Failed to create the file
                    die('Failed to create the JSON file.');
                }
            }
                // Convert the JSON data to a PHP associative array
                $collection = json_decode($jsonData, true);

                // Get the last assigned ID or initialize to 0 if no data exists yet
                $last_id = !empty($collection) ? max(array_keys($collection)) : 0;
                // Generate a new ID by incrementing the last ID 
                $new_id = $last_id + 1;
                    
                // Add the new student data with the key as it's new ID and add one more attribute id into the studentarr array
                $studentarr =['id'=>$new_id] + $studentarr;
                $collection[$new_id] = $studentarr;

                // Create an empty array to hold the converted json objects
                $arrayOfObjects = [];

                // Iterate through the keys and convert each inner object into an associative array
                foreach ($collection as $key => $value) {
                    $arrayOfObjects[] = $value;
                }

                // Save the updated data to the JSON file
                file_put_contents($file, json_encode($arrayOfObjects));
        }

    }
    $name       = $_POST["name"];
    $age        = $_POST["age"];
    $gender     = $_POST["gender"];
    $posts      = $_POST["posts"];
    $filename   = $_POST["filename"];
    $studobj = new Student($name, $age, $gender, $posts);
    $studobj->saveJsonIntoArray($filename);
}
?>

