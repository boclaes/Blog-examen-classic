<?php
declare(strict_types=1);
require_once "database/connection.php";
session_start();

$_SESSION["id_blog_comment"] = $_GET['id'];

$sql = "SELECT title, author, text, created_at, likes  FROM todos WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $_GET["id"], PDO::PARAM_STR);
$stmt->execute();
$sql_2 = "SELECT id, id_blog, author, text, status  FROM comments WHERE id_blog=:id";
$stmt_2 = $pdo->prepare($sql_2);
$stmt_2->bindParam(":id", $_GET["id"], PDO::PARAM_STR);
$stmt_2->execute();

?>
<?php include "./snippets/header_main.php" ?>
<h1>Text</h1>
<?php foreach ($stmt as $user): ?>
    <h2>The title is: <?=$user["title"]?></h2>
    <h2>The Author is: <?=$user["author"]?></h2>
    <p><?=$user["text"]?></p>
    <p>This blog has <?=$user["likes"]?> likes</p>
    <p>This blog is created at. <?=$user["created_at"]?></p>
<?php endforeach;?>
    <br>
    <p>These here are the comments.</p>
<?php foreach ($stmt_2 as $comments): ?>
<?php if ($comments["status"] == 1 and (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)): ?>
    <p>The author is: <?=$comments["author"]?></p>
    <p><?=$comments["text"]?></p>
    <br>
<?php elseif($comments["status"] == 1 and $comments["author"] == $_SESSION["email"]): ?>
    <p>The author is: <?=$comments["author"]?></p>
    <p><?=$comments["text"]?></p>
    <td><form method="POST" action="functions/function_pages/delete_comments.php"><input type="hidden" value= <?=$comments['id']?> name="id"><input type="submit" value="Delete"></form></td>
    <br>
<?php elseif($comments["status"] == 1): ?>
    <p>The author is: <?=$comments["author"]?></p>
    <p><?=$comments["text"]?></p>
    <br>
<?php else: ?>
<p>This comment has been deleted</p>
<br>
<?php endif; endforeach;?>
<a href="index.php">
    <button>Go Back</button>
<?php if (isset($_SESSION["loggedin"])): ?>
<a href="comment.php">
    <button>Add comment</button>
<?php endif;?>
<?php include "./snippets/footer.php";?>
