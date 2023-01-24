<?php
require_once "./database/connection.php";
session_start();
$sql = "SELECT username FROM users WHERE id = :session";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":session", $_SESSION["id"], PDO::PARAM_STR);
$stmt->execute();
foreach ($stmt as $row){
    print_r($row["username"]);
}
