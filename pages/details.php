<?php
declare(strict_types=1);
require_once "../functions/helpers.php";
$_SESSION["url"] = $_SERVER["REQUEST_URI"];
$_SESSION["id_blog_comment"] = $_GET['id'];

$db = getDBLogin();

$stmt = getDetails($db, $_GET['id']);
$stmt_comments = getComments($db, $_GET['id']);
$stmt_likes = getLikesDetails($db, $_GET['id']);


$i = 0;
foreach ($stmt_likes as $likes) {
    $i++;
}


?>
<?php include "../snippets/header_main.php" ?>
<h1>Details of the blog</h1>

<?php foreach ($stmt as $user): ?>
    <h2>The title is: <?=$user["title"]?></h2>
    <h2>The Author is: <?=$user["author"]?></h2>
    <p><?=$user["text"]?></p>
    <p>This blog is created at. <?=$user["created_at"]?></p>
<?php endforeach;?>

<p>This blog has <?=$i?> Likes</p>
<br>
<p>These here are the comments.</p>

<?php foreach ($stmt_comments as $comments): ?>
    <?php if ($comments["status"] == 1 and (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)): ?>
        <p>The author is: <?=$comments["author"]?></p>
        <p><?=$comments["text"]?></p>
        <br>

    <?php elseif($comments["status"] == 1 and $comments["author"] == $_SESSION["email"]): ?>
        <p>The author is: <?=$comments["author"]?></p>
        <p><?=$comments["text"]?></p>
        <td><form method="POST" action="../functions/function_pages/delete_comments.php"><input type="hidden" value= <?=$comments['id']?> name="id"><input type="submit" value="Delete"></form></td>
        <br>

    <?php elseif($comments["status"] == 1): ?>
        <p>The author is: <?=$comments["author"]?></p>
        <p><?=$comments["text"]?></p>
        <br>

    <?php else: ?>
        <p>This comment has been deleted</p>
        <br>
    <?php endif; endforeach;?>

<a href="../index.php">
    <button>Go Back</button>
    <?php if (isset($_SESSION["loggedin"])): ?>
    <a href="comment.php">
        <button>Add comment</button>

        <?php endif;?>
        <?php include "../snippets/footer.php";?>
