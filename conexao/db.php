<?php
$host = "localhost";
$user = "root";
$pass = "150297@Zem";
$db   = "site_marcos";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
