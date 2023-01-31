<?php
session_start();
require_once "../../database/connection.php";

$like_counter = 1;

$sql = "SELECT user_id, blog_id FROM likes WHERE user_id = :user_id AND blog_id = :blog_id ";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":user_id", $_SESSION["id"], PDO::PARAM_STR);
$stmt->bindParam(":blog_id", $_POST["blog_id"], PDO::PARAM_STR);
$stmt->execute();
$x = $stmt -> fetch();

if ($x["user_id"] == $_SESSION["id"] && $x["blog_id"] == $_POST["blog_id"]){
    $sql_2 = "DELETE FROM likes WHERE user_id = :user_id AND blog_id = :blog_id";
    $stmt_2 = $pdo->prepare($sql_2);
    $stmt_2->bindParam(":user_id", $_SESSION["id"], PDO::PARAM_STR);
    $stmt_2->bindParam(":blog_id", $_POST["blog_id"], PDO::PARAM_STR);
}
else {
    $sql_2 = "INSERT INTO likes (user_id, blog_id, likes) VALUES (:user_id, :blog_id, :likes)";
    $stmt_2 = $pdo->prepare($sql_2);
    $stmt_2->bindParam(":user_id", $_SESSION["id"], PDO::PARAM_STR);
    $stmt_2->bindParam(":blog_id", $_POST["blog_id"], PDO::PARAM_STR);
    $stmt_2->bindParam(":likes", $like_counter, PDO::PARAM_STR);
}
$stmt_2->execute();
header("location: ../../index.php");
