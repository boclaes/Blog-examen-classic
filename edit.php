<?php
require_once "functions/helpers.php";
$_SESSION["id_edit"] = $_POST['id'];

$db = getLogin();

$stmt = getEdit($db, $_POST['id'])

?>
<?php include "./snippets/header_main.php"; ?>
<form
    action="functions/function_pages/edit_page.php" method="post">
    <?php foreach($stmt as $row): ?>
    <label>Title</label>
    <input type="text" name="title" value=<?=$row["title"]?> required>
    <label>Text</label>
    <input type="text" name="blog" value="<?=$row["text"]?>" required>
    <?php endforeach; ?>
    <input type="submit">
    <br>
</form>
<a href="index.php">
    <button>Go back</button>
<?php include "./snippets/footer.php";?>
