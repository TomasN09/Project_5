<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Survey questions</title>
</head>

<body>
    <div class="container">
        <div class="m-5">
            <h1>Otázky ankety</h1>

            <h5>Přehled všech zadaných otázek</h5>

            <!--enter new question in to database-->

            <?php
            require('login.php');
            if (isset($_POST["question"])) { // avoid error

                if (!$con) {
                    die("Nelze se připojit k databázovému serveru!</body></html>");
                }
                mysqli_query($con, "SET NAMES 'utf8'");
                if (mysqli_query(
                    $con,
                    "INSERT INTO otazky(otazka_text) VALUES('" .
                        addslashes($_POST["question"]) . "')"
                )) {
                    /* echo "Otázka byla vložena."; */
                } else {
                    echo "Vložení otázky se nezdařilo. " . mysqli_error($con);
                }
                mysqli_close($con);
            }
            ?>

            <!--show all questions from database-->

            <?php
            require('login.php');
            if (!$con) {
                die("Nelze se připojit k databázovému serveru!</body></html>");
            }
            mysqli_query($con, "SET NAMES 'utf8'");
            if (!($vysledek = mysqli_query($con, "SELECT id_otazka, otazka_text FROM otazky"))) {
                die("Otázky nelze zobrazit.</body></html>");
            }
            echo " <div class='ms-3'>";
            while ($radek = mysqli_fetch_array($vysledek)) {
                $id = $radek["id_otazka"];
                echo ("<p>" . htmlspecialchars($radek["otazka_text"]) . "  <a href='question.php?id=" . $id . "'>diskuse</a> </p>");
            }
            echo " </div>";
            mysqli_free_result($vysledek);
            mysqli_close($con);
            ?>


            <form action="main.php" method="POST">
                <label class="form-label">
                    <h6 class="mb-0">Nová otázka</h6>
                </label>
                <div class="row">
                    <div class="col col-12 col-md-6 col-4">
                        <textarea name="question" id="" rows="3" placeholder="zde napište otázku" class="form-control"></textarea><br>
                    </div>
                </div>
                <input type="submit" value="Vytvořit novou anketu">
            </form>
            <br>

            <a href="Q&A.php">zobrazení všech otázek s hlasováním</a>
        </div>
    </div>
</body>

</html>