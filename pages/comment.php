<?php
include "../functions/helpers.php";

$db = getDBLogin();

if(isset($_POST['submit'])){
    if(!empty($_POST['comment'])) {
        comment($db, $_SESSION["id_blog_comment"], $_SESSION["email"],  $_SESSION["url"], $_POST["comment"] );
    }
}
?>

<?php include "../snippets/header_main.php"; ?>
<form
    action="" method="post">
    <label>comment</label>
    <input type="text" name="comment" required>
    <button type="submit" name="submit">Comment opslaan</button>
    <br>
</form>
<a href=<?=$_SESSION["url"]?>>
    <button>Go back</button>
<?php include "../snippets/footer.php";?>
