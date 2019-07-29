<?php
require_once("connection.php");

$result4 = $connect->query("SELECT campus FROM lieux");
$result = $connect->query("SELECT classe FROM classes");
$result2 = $connect->query("SELECT id, nom FROM users WHERE role = 'intervenant'");

function verifyFields($field)
{
    $date = filter_input(INPUT_POST, "date");
    $time = filter_input(INPUT_POST, "time");
    $duration = filter_input(INPUT_POST, "duration");
    $lieux = filter_input(INPUT_POST, "lieux");
    $cours = filter_input(INPUT_POST, "cours");
    $intervenant = filter_input(INPUT_POST, "intervenant");

    $msgReturn = "";

    switch ($field) {
        case "date":
            if ($date == "") {
                $msgReturn .= "Please select a date<br>";
            }
            break;
        case "time":
            if ($time == "") {
                $msgReturn .= "Please select a time<br>";
            }
            break;
        case "duration":
            if ($duration == "") {
                $msgReturn .= "Please select duration<br>";
            }
            break;
        case "lieux":
            if ($lieux == "") {
                $msgReturn .= "Please select location<br>";
            }
            break;
        case "cours":
            if ($cours == "") {
                $msgReturn .= "Please select the subject<br>";
            }
            break;
        case "intervenant":
            if ($intervenant == "") {
                $msgReturn .= "Please select the teacher<br>";
            }
            break;
    }
    return $msgReturn;
}

function checkError($post)
{
    $Error = [];
    foreach ($post as $key => $value) {
        $err = verifyFields($key);
        if (strlen($err) > 0)
            $Error[] = $err;
    }
    return $Error;
}

if (isset($_POST["date"], $_POST["time"], $_POST["duration"], $_POST["lieux"], $_POST["cours"], $_POST["intervenant"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $date = filter_input(INPUT_POST, "date");
        $time = filter_input(INPUT_POST, "time");
        $duration = filter_input(INPUT_POST, "duration");
        $lieux = filter_input(INPUT_POST, "lieux");
        $cours = filter_input(INPUT_POST, "cours");
        $intervenant = filter_input(INPUT_POST, "intervenant");
        // $conn = new PDO('mysql:host=localhost;dbname=attendance', $dbUserName, $dbPassword);
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {
            $sql = "INSERT INTO `planning`(`id_planning`, `date`, `time`, `duration`, `lieux`, `cours`, `intervenant`) VALUES (NULL,'" . $date . "','" . $time . "','" . $duration . "','" . $lieux . "','" . $cours . "','" . $intervenant . "')";
            $add = $conn->prepare($sql);
            $add->execute();
            $Success;
            header('Location: addPlanning.php?id=Database updated');
        }
        $conn->close();
    }
}