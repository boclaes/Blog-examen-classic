<?php
include "./vendor/autoload.php";
include "./functions/helpers.php";
include "database/connection.php";
registerExceptionHandler();
session_start();

$sql = "SELECT title, text FROM todos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $_POST['id'], PDO::PARAM_STR);
$stmt->execute();

?>
<?php include "./snippets/header_main.php"; ?>
<form
        action="edit_page.php" method="post">
    <?php foreach($stmt as $row): ?>
    <label>Title</label>
    <input type="text" name="title" value=<?=$row["title"]?> required>
    <label>Text</label>
    <input type="text" name="blog" value="<?=$row["text"]?>" required>
    <?php endforeach; ?>
    <input type="submit">
    <br>
</form>
<a href="welcome.php">
    <button>Go back</button>
<?php include "./snippets/footer.php";?>
