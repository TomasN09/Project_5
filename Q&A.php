<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>QuestionsAnswers</title>
</head>

<body>
    <div class="container">
        <div class="m-5">
            <h1>Všechny anketní otázky</h1>

            <!--show answers for current question from database + update vote-->
            <?php
            require('login.php');

            if (isset($_GET['id'])) {
                if (!$con) {
                    die("Nelze se připojit k databázovému serveru!</body></html>");
                }
                mysqli_query($con, "SET NAMES 'utf8'");
                mysqli_query(
                    $con,
                    "UPDATE odpovedi SET hlasu = hlasu + 1 WHERE id_odpoved = " . addslashes($_GET['id'])
                );
            }

            if (!$con) {
                die("Nelze se připojit k databázovému serveru!</body></html>");
            }
            mysqli_query($con, "SET NAMES 'utf8'");
            $vysledekOt = mysqli_query($con, "SELECT * FROM otazky");

            while ($radekOt = mysqli_fetch_array($vysledekOt)) {
                echo "<div class='border p-3'>";
                echo ("<h3>" . htmlspecialchars($radekOt["otazka_text"]) . "</h3>");
                $ot = $radekOt["id_otazka"];
                $vysledekOdp = mysqli_query($con, "SELECT * FROM odpovedi WHERE id_otazka=$ot");
                echo " <div class='ms-3'>";
                while ($radekOdp = mysqli_fetch_array($vysledekOdp)) {
                    $idOdp = $radekOdp["id_odpoved"];
                    echo "<p>";
                    echo htmlspecialchars($radekOdp["odpoved_text"]);
                    echo " (<a href='Q&A.php?id=" . $idOdp . "'>" . htmlspecialchars($radekOdp["hlasu"]) . " hlasů)</a>";
                    echo "</p>";
                }
                echo " </div>";
                echo "</div>";
                mysqli_free_result($vysledekOdp);
            }

            ?>
            <br>
            <a href="main.php">zpět na hlavní stránku</a><br>
        </div>
    </div>

</body>

</html>