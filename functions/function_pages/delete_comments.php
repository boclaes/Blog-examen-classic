<?php
declare(strict_types=1);
require_once "../../database/connection.php";
session_start();

$now = date('y-m-d H:i:s');
$zero = 0;

$sql = "UPDATE comments SET deleted_at = :now WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":now", $now, PDO::PARAM_STR);
$stmt->bindParam(":id", $_POST['id'], PDO::PARAM_STR);
$stmt->execute();
$sql2 = "UPDATE comments SET status = :zero WHERE id = :id";
$stmt = $pdo->prepare($sql2);
$stmt->bindParam(":zero", $zero, PDO::PARAM_STR);
$stmt->bindParam(":id", $_POST['id'], PDO::PARAM_STR);
$stmt->execute();
header("location: ../../index.php");
