<?php
require_once "../functions/helpers.php";

$db = getDBLogin();

$stmt = getEdit($db, $_POST["id"]);

if(isset($_POST['submit'])){
    if(!empty($_POST['title']) && !empty($_POST['blog'])) {
        edit($db, $_POST["title"], $_POST["blog"]);
    }
}

?>
<?php include "../snippets/header_main.php"; ?>
<form
    action="" method="post">
    <?php foreach($stmt as $row): ?>
        <label>Title</label>
        <input type="text" name="title" value=<?=$row["title"]?> required>
        <label>Text</label>
        <input type="text" name="blog" value="<?=$row["text"]?>" required>
        <input type="hidden" name="id" value="<?=$_POST["id"]?>">
    <?php endforeach; ?>
    <button type="submit" name="submit">Artikel opslaan</button>
    <br>
</form>
<a href="../index.php">
    <button>Go back</button>
    <?php include "../snippets/footer.php";?>
