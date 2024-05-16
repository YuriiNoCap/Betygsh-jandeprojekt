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
                // $full_name = $row["FullName"] . " ";
                session_start();
                $_SESSION["username"] = $_POST["username"];
                header("Location: products.php");
                exit();
            }
        }
    }

    $conn->close();
    ?>

</body>

</html>