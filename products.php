<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>   
    <link rel="stylesheet" href="style1.css" />
</head>

<body>

    <header>
        <h1>DJ-utrustning handelsplats</h1>
        <nav>
            <a href="products.php">Hem</a>
            <a href="varukorg.php">Varukorg</a>
            <a href="konto.php">Konto</a>
            <a href="loggaut.php">Logga ut</a>
        </nav>
    </header>

    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db-users";
    $conn = new mysqli($servername, $username, $password, $dbname);


    if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
        $username = $_SESSION["username"];
        $sql_user = "SELECT UserID FROM users WHERE Username = '$username'";
        $result_user = $conn->query($sql_user);

        if ($result_user->num_rows == 1) {
            $row_user = $result_user->fetch_assoc();
            $user_id = $row_user["UserID"];

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buy"])) {
                $product_id = $_POST["product_id"];

                $sql_varukorg = "INSERT INTO varukorg (user_id, product_id ) VALUES ('$user_id', '$product_id')";
                if ($conn->query($sql_varukorg) === TRUE) {
                } else {
                    echo "Fel: " . $sql_varukorg . "<br>" . $conn->error;
                }
            }

            $sql_products = "SELECT * FROM products";
            $result_products = $conn->query($sql_products);

            if ($result_products->num_rows > 0) {
                echo "<div class='container'>";
                while ($row_product = $result_products->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<h3>" . $row_product["produktnamn"] . "</h3>";
                    echo "<p>" . $row_product["beskrivning"] . "</p>";
                    echo "<p class='price'>Pris: $" . $row_product["pris"] . "</p>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='product_id' value='" . $row_product["ProductID"] . "'>";
                    echo "<button type='submit' name='buy'>Köp</button>";
                    echo "</form>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "Inga produkter hittades";
            }
        } else {
            echo "Användaren kunde inte hittas.";
        }
    } else {
        echo "Du är inte inloggad.";
    }


    $conn->close();
    ?>

</body>

</html>