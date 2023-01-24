<?php
declare(strict_types=1);
include "database/connection.php";
session_start();

$one = 1;

$sql = "UPDATE todos SET status = :one WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":one", $one, PDO::PARAM_STR);
$stmt->bindParam(":id", $_POST['id'], PDO::PARAM_STR);
$stmt->execute();
header("location: index.php");