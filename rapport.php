<?php
require_once("rapportTreatment.php");
require_once("connection.php");
require_once("rapportRegard.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Créer un rapport d'absence</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script>
        function showUser(str) {
            if (str == "") {
                document.getElementById("etudiant").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("etudiant").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "getUsers.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
</head>

<body>
    <?php
    // If any errors, show them using Bootstrap
    if (isset($errors) && sizeof($errors) > 0) { ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?php // $errors is an array we turn to a string using the IMPLODE fonction 
                echo implode(" ", $error);
                ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php } ?>
    <div id="formDiv" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Créer un rapport d'absence</h3>
            </div>
            <form action="rapportRegard.php" method="post" class="modal-content">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <select name="classe" id="classe" class="form-control" onchange="showUser(this.value)">
                            <option value="">Sélectionnez la classe</option>
                            <?php
                            while ($rows = $result->fetch_assoc()) {
                                $classe = $rows['classe'];
                                echo "<option value='" . $rows['classe'] . "'>$classe</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12" )>
                        <select name="etudiant" id="etudiant" class="form-control">
                            <option value="">Sélectionnez l'étudiant</option>
                            <?php
                            while ($rows3 = $result3->fetch_assoc()) {
                                $etudiant = $rows3['nom'];
                                echo "<option value='" . $rows3['id'] . "'>$etudiant</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-width">Créer un rapport d'absence</button>
                    <a href="mainMenu.php" class="btn btn-danger btn-width">Annule / Retour</a>
                </div>
            </form>
        </div>
    </div>
    <?php
    if (!isset($_SESSION['admin'])) {
        require_once("ifSessionNotSet.php");
    }
    ?>
    <script>
        $(document).ready(function() {
            var etudiantBlocked = $("#etudiant");
            var selectedOrNot = $("#classe");

            selectedOrNot.on("click", function() {
                if ($(this).val() != "") {
                    etudiantBlocked.removeAttr("disabled");
                } else {
                    etudiantBlocked.attr("disabled", "");
                }
            });
        });
    </script>
</body>

</html>