<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
        }

        .product {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            position: relative;
            transition: transform 0.5s ease;
            cursor: pointer;
        }

        .product:hover {
            transform: scale(1.08);
        }

        .product h3 {
            margin-top: 0;
            color: #333;
        }

        .product p {
            margin-bottom: 5px;
        }

        .product .price {
            font-weight: bold;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        nav {
            display: flex;
            justify-content: center;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .cart {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #fff;
            color: #333;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #333;
        }
    </style>


</head>

<body>

    <header>
        <h1>Min E-handelsplats</h1>
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
                $_SESSION["username"] = $_POST["username"]; // Spara användarnamnet i sessionen
            }
        }
    } else {
        echo "0 results";
    }


    if ($login_success) {

        // Kod för att hämta och visa DJ-utrustningsprodukter
        $sql_products = "SELECT * FROM dj_utrustning";
        $result_products = $conn->query($sql_products);

        if ($result_products->num_rows > 0) {
            echo "<div class='container'>";
            while ($row_product = $result_products->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<h3>" . $row_product["produktnamn"] . "</h3>";
                echo "<p>" . $row_product["beskrivning"] . "</p>";
                echo "<p class='price'>Pris: $" . $row_product["pris"] . "</p>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "Inga produkter hittades";
        }
    } else {
        echo "Inloggning misslyckades";
    }
    $conn->close();


    ?>

</body>

</html>