<?php
include "../functions/helpers.php";

$db = getDBLogin();

if(isset($_POST['submit'])){
    if(!empty($_POST['title']) && !empty($_POST['blog'])) {
        addBlog($db, $_POST["title"], $_POST["blog"]);
    }
}

?>
<?php include "../snippets/header_main.php"; ?>
<form
     action="" method="post">
    <label>Title</label>
    <input type="text" name="title" required>
    <label>Text</label>
    <input type="text" name="blog" required>
    <button type="submit" name="submit">Artikel opslaan</button>
    <br>
</form>

<a href="../index.php">
    <button>Go back</button>
    <?php include "../snippets/footer.php";?>
