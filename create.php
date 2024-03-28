<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db-users";
$conn = new mysqli($servername, $username, $password, $dbname);

$fullname = $_POST['fullname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (FullName, Username, Email, Password) VALUES ('$fullname', '$username', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Konto skapat framgångsrikt";
    echo '<br><br><a href="index.html">Gå tillbaka till logga in</a>';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
