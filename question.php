<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Question detail</title>
</head>

<body>
    <div class="container">
        <div class="m-5">

            <?php
            require('login.php');
            /*<!--enter new answer in to database-->*/
            if (isset($_POST["odpoved"])) {
                if (!$con) {
                    die("Nelze se připojit k databázovému serveru!</body></html>");
                }
                mysqli_query($con, "SET NAMES 'utf8'");
                if (mysqli_query(
                    $con,
                    "INSERT INTO odpovedi(id_otazka, odpoved_text) VALUES('" .
                        addslashes($_POST["otazka_id"]) . "', '" .
                        addslashes($_POST["odpoved"]) . "')"
                )) {
                    /*  echo "Odpověď byla uložena.<br><br>"; */
                } else {
                    echo "Vložení odpovědi se nezdařilo. " . mysqli_error($con);
                }
                mysqli_close($con);
            }
            ?>

            <!--pulling all answers to a given question from the database and show-->
            <?php
            require('login.php');
            /*pulling a relevant question from database*/
            if (isset($_GET["id"])) {

                if (!$con) {
                    die("Nelze se připojit k databázovému serveru!</body></html>");
                }

                mysqli_query($con, "SET NAMES 'utf8'");
                $id_otazky = addslashes($_GET["id"]);
                /* echo ("<h1>Číslo otázky " . $id_otazky . "</h1>"); */
                if (!($vysledek = mysqli_query($con, "SELECT otazka_text FROM otazky WHERE id_otazka='$id_otazky'"))) {
                    die("Otázky nelze zobrazit.</body></html>");
                }

                while ($radek = mysqli_fetch_array($vysledek)) {
                    echo ("<p><h5>" . htmlspecialchars($radek["otazka_text"]) . "</h5></p>");
                }
                mysqli_free_result($vysledek);
                mysqli_close($con);
            }
            ?>
            <div class="ms-3">
                <?php

                require('login.php');
                if (!$con) {
                    die("Nelze se připojit k databázovému serveru!</body></html>");
                }
                mysqli_query($con, "SET NAMES 'utf8'");
                if (!($vysledek2 = mysqli_query($con, "SELECT * FROM odpovedi WHERE id_otazka=$id_otazky"))) {
                    die("Otázky nelze zobrazit.</body></html>");
                }

                while ($radek2 = mysqli_fetch_array($vysledek2)) {
                    echo ("<p>" . htmlspecialchars($radek2["odpoved_text"]) . "</p>");
                }

                mysqli_free_result($vysledek2);
                mysqli_close($con);
                ?>
            </div>
            <!--form to enter a new answer-->
            <form action="question.php?id=<?php echo htmlspecialchars($_GET["id"]) ?>" method="POST">
                <label class="form-label">
                    <h6 class="mb-0">Nová odpověď</h6>
                </label>
                <div class="row">
                    <div class="col col-12 col-md-6 col-4">
                        <textarea name="odpoved" cols="50" rows="5" placeholder="zadejte odpověď na otázku" class="form-control"></textarea><br>
                    </div>
                </div>
                <input type="hidden" name="otazka_id" value='<?php echo htmlspecialchars($_GET["id"]) ?>'>
                <input type="submit" value="Přidat odpověď">
            </form>
            <br>

            <a href="Q&A.php">zobrazení všech otázek s hlasováním</a><br><br>
            <a href="main.php">zpět</a>
        </div>
    </div>
</body>

</html>