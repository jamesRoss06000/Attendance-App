<?php
require_once("connection.php");

$result4 = $connect->query("SELECT campus FROM lieux");
$result = $connect->query("SELECT classe FROM classes");
$result2 = $connect->query("SELECT id, nom FROM users WHERE role = 'intervenant'");
$result3 = $connect->query("SELECT id, nom FROM users WHERE role = 'etudiant'");

function verifyFields($field)
{
    $classe = filter_input(INPUT_POST, "classe");
    $etudiant = filter_input(INPUT_POST, "etudiant");
    $intervenant_name = filter_input(INPUT_POST, "intervenant");
    $cours = filter_input(INPUT_POST, "cours");
    $lieux = filter_input(INPUT_POST, "lieux");
    $date = filter_input(INPUT_POST, "date");

    $msgReturn = "";

    switch ($field) {
        case "classe":
            if ($classe == "") {
                $msgReturn .= "Please select a class<br>";
            }
            break;
        case "etudiant":
            if ($etudiant == "") {
                $msgReturn .= "Please select a student<br>";
            }
            break;
        case "date":
            if ($date == "") {
                $msgReturn .= "Please select a date<br>";
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
            if ($intervenant_name == "") {
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

if (isset($_POST["date"], $_POST["classe"], $_POST["etudiant"], $_POST["lieux"], $_POST["cours"], $_POST["intervenant"])) {
    $errors = checkError($_POST);
    if (empty($errors)) {
        $classe = filter_input(INPUT_POST, "classe");
        $etudiant = filter_input(INPUT_POST, "etudiant");
        $intervenant_name = filter_input(INPUT_POST, "intervenant");
        $cours = filter_input(INPUT_POST, "cours");
        $lieux = filter_input(INPUT_POST, "lieux");
        $adresse = filter_input(INPUT_POST, "adresse");
        $date = filter_input(INPUT_POST, "date");
        $debut_am = filter_input(INPUT_POST, "debut_am");
        $fin_am = filter_input(INPUT_POST, "fin_am");
        $debut_pm = filter_input(INPUT_POST, "debut_pm");
        $fin_pm = filter_input(INPUT_POST, "fin_pm");
        $present = "non";
        $conn = new PDO('mysql:host=localhost;dbname=attendance', $dbUserName, $dbPassword);

        $getId = $conn->prepare("SELECT id FROM users WHERE nom = :intervenant_name");
        $getId->execute([':intervenant_name' => $intervenant_name]);
        $details = $getId->fetchAll();

        $intervenant_id = $details[0]['id'];
        var_dump($id);
        if (!$conn) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        } else {

            $sql = $conn->prepare("INSERT INTO `cours`(`id`, `date`,  `lieux`, `adresse`,  `cours`, `debut_am`, `fin_am`, `debut_pm`, `fin_pm`, `intervenant_name`, `intervenant_id`, `etudiant`, `classe`, `present`) VALUES (NULL, :date, :lieux, :adresse, :cours, :debut_am, :fin_am, :debut_pm, :fin_pm, :intervenant_name, :intervenant_id, :etudiant, :classe, :present)");
            $sql->execute([':date' => $date, ':lieux' => $lieux, ':adresse' => $adresse,  ':cours' => $cours, ':debut_am' => $debut_am, ':fin_am' => $fin_am, ':debut_pm' => $debut_pm, ':fin_pm' => $fin_pm, ':intervenant_name' => $intervenant_name, ':intervenant_id' => $intervenant_id, ':etudiant' => $etudiant, ':classe' => $classe, ':present' => $present]);
            header('Location: addEtudiantToCours.php?id=Database updated');
        }
        // mysqli_close($conn);
    }
}