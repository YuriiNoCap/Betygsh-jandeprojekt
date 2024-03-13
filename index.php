<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    $korrektAnvandarnamn = "Yurii";
    $korrektLosenord = "12345";

    $anvandarnamn = $_POST['username'];
    $losenord = $_POST['password'];

    if ($anvandarnamn == $korrektAnvandarnamn && $losenord == $korrektLosenord) {
        echo "Välkommen, $anvandarnamn!";
    } else {
        echo "Fel användarnamn eller lösenord. Försök igen.";
    }

    ?>


</body>

</html>