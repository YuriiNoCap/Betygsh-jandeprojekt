<?php
session_start();
if (isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    echo "Du är inloggad som " . $_SESSION["username"];
    echo "<br><a href='logga_ut.php'>Logga ut</a>";
} else {
    echo "Du är inte inloggad.";
}
