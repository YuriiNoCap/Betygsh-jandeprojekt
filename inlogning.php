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
            <a href="#">Hem</a>
            <a href="#">Produkter</a>
            <a href="#">Om oss</a>
            <a href="#">Kontakt</a>
        </nav>
        <div class="cart">Varukorg (0)</div>
    </header>

    <?php

    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db-users";
    $conn = new mysqli($servername, $username, $password, $dbname);

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $login_success = false;
    $full_name = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hash = $row["Password"];
            if (
                $row["Username"] == $_POST["username"] &&
                password_verify($_POST["password"], $hash)
            ) {
                $login_success = true;
                $full_name = $row["FullName"] . " ";
                $_SESSION["username"] = $_POST["username"];
            }
        }
    } else {
        echo "0 results";
    }


    if ($login_success) {

        $sql_products = "SELECT * FROM dj_utrustning";
        $result_products = $conn->query($sql_products);

        if ($result_products->num_rows > 0) {
            echo "<div class='container'>";
            while ($row_product = $result_products->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<h3>" . $row_product["produktnamn"] . "</h3>";
                echo "<p>" . $row_product["beskrivning"] . "</p>";
                echo "<p class='price'>Pris: $" . $row_product["pris"] . "</p>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $row_product["id"] . "'>";
                echo "<button type='submit' name='buy'>Köp</button>";
                echo "</form>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "Inga produkter hittades";
        }
    } else {
        echo "Inloggning misslyckades";
    }

    if (isset($_POST['buy'])) {
        $product_id = $_POST['product_id'];
        // Lägger INTE till produkter i varukorg!!!
        $sql_add_to_cart = "INSERT INTO varukorg (user_id, product_id) VALUES ('$user_id', '$product_id')";
        if ($conn->query($sql_add_to_cart) === TRUE) {
            echo "Produkten har lagts till i varukorgen.";
        } else {
            echo "Fel: " . $sql_add_to_cart . "<br>" . $conn->error;
        }
    }


    $conn->close();


    ?>

</body>

</html>