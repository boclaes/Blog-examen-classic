<?php
declare(strict_types=1);
include "database/connection.php";

$sql = "SELECT title, author, text, created_at  FROM todos WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $_GET["id"], PDO::PARAM_STR);
$stmt->execute();

?>
<?php include "./snippets/header_main.php" ?>
<h1>Text</h1>
<?php foreach ($stmt as $user): ?>
    <h2>The title is: <?=$user["title"]?></h2>
    <h2>The Author is: <?=$user["author"]?></h2>
    <p><?=$user["text"]?></p>
    <p>This blog is created at. <?=$user["created_at"]?></p>
<?php endforeach;?>
<a href="welcome.php">
    <button>Go Back</button>
<?php include "./snippets/footer.php";?>
