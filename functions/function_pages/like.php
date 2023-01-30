<?php
require_once "./database/connection.php";

$like_hardcoded = 1;

$sql = "SELECT likes FROM todos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $_POST['like'], PDO::PARAM_STR);
$stmt->execute();

foreach ($stmt as $row){
    $like_new = $row["likes"] + $like_hardcoded;
}

$sql_2 = "UPDATE todos SET likes = :like_new WHERE id = :id";
$stmt = $pdo->prepare($sql_2);
$stmt->bindParam(":like_new", $like_new, PDO::PARAM_STR);
$stmt->bindParam(":id", $_POST['like'], PDO::PARAM_STR);
$stmt->execute();
header("location: index.php");
