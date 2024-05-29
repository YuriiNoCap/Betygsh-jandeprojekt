<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uppdatera Konto</title>
    <link rel="stylesheet" href="style1.css" />
</head>

<body>
    <header>
        <h1>Uppdatera Konto</h1>
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
        $sql_user = "SELECT * FROM users WHERE Username = '$username'";
        $result_user = $conn->query($sql_user);

        if ($result_user->num_rows == 1) {
            $row_user = $result_user->fetch_assoc();
            $user_id = $row_user["UserID"];
            $fullname = $row_user["FullName"];
            $email = $row_user["Email"];
        } else {
            echo "---";
            exit();
        }
    } else {
        echo "är inte inloggad";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["update"])) {
            $new_fullname = $_POST["fullname"];

            $sql_update = "UPDATE users SET FullName = '$new_fullname' WHERE UserID = '$user_id'";
            if ($conn->query($sql_update) === TRUE) {
                echo "Kontot har uppdaterats";
            } else {
                echo "Error: " . $sql_update;
            }
        }

        if (isset($_POST["delete"])) {
            $sql_delete = "DELETE FROM varukorg WHERE user_id = '$user_id'";
            if ($conn->query($sql_delete) === TRUE) {
                $sql_delete_user = "DELETE FROM users WHERE UserID = '$user_id'";
                if ($conn->query($sql_delete_user) === TRUE) {
                    session_destroy();
                    header("Location: index.html");
                    exit();
                } else {
                    echo "Error: " . $sql_delete_user;
                }
            } else {
                echo "Error: " . $sql_delete;
            }
        }
    }

    $conn->close();
    ?>

    <div class="container">
        <form method="post">
            <h2>Uppdatera dina uppgifter</h2> 
            <label for="fullname">Fullständigt namn:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" required><br />
            <input type="submit" name="update" value="Uppdatera">
        </form>

        <form method="post">
            <h2>Ta bort ditt konto</h2>
            <input type="submit" name="delete" value="Ta bort konto">
        </form>
    </div>

</body>

</html>
