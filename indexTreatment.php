<?php
require_once("connection.php");

if (isset($_POST["email"], $_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT email, password, role FROM users WHERE email = '" . $email . "' AND password = '" . $password . "'";
    $result1 = $conn->query($sql);
    if ($result1->rowCount() > 0 && $email == "admin@admin.com") {
        $LoggedIn = true;
        session_start();
        $_SESSION['admin'] = "Admin logged In";
        sleep(2);
        header("Location: mainMenu.php");
    } else {
        $errors = "The username or password are incorrect!";
    }
}