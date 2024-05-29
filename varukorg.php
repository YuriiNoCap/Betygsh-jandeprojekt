<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varukorg</title>
    <link rel="stylesheet" href="style1.css" />
</head>

<body>

    <header>
        <h1>Dina varor</h1>
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

            $sql_cart = "SELECT * FROM varukorg 
                 JOIN products ON varukorg.product_id = products.ProductID 
                 WHERE varukorg.user_id = '$user_id'";
            $result_cart = $conn->query($sql_cart);

            if ($result_cart->num_rows > 0) {
                echo "<div class='container'>";
                while ($row_cart = $result_cart->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<h3>" . $row_cart["produktnamn"] . "</h3>";
                    echo "<p>" . $row_cart["beskrivning"] . "</p>";
                    echo "<p>Pris: $" . $row_cart["pris"] . "</p>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='varukorg_id' value='" . $row_cart["varukorg_id"] . "'>";
                    echo "<input type='hidden' name='product_id' value='" . $row_cart["product_id"] . "'>";
                    echo "<button type='submit' name='delete'>Ta bort</button>";
                    echo "</form>";

                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>Din varukorg är tom.</p>";
            }
        } else {
            echo "Användaren kunde inte hittas.";
        }
    } else {
        echo "Användaren kunde inte hittas.";
    }

    if (isset($_POST["delete"])) {
        $varukorg_id = $_POST["varukorg_id"];
        $sql_delete = "DELETE FROM varukorg WHERE varukorg_id = '$varukorg_id'";
        if ($conn->query($sql_delete) === TRUE) {
            header("Location: varukorg.php");
            exit();
        } else {
            echo "Error: " . $sql_delete . "<br>" . $conn->error;
        }
    }

    $conn->close();
    ?>

</body>

</html>