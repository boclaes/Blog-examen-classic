<?php
include "vendor/autoload.php";
include "functions/helpers.php";
registerExceptionHandler();
session_start();
?>

<?php include "./snippets/header_main.php"; ?>
<form
    action="functions/function_pages/comment_page.php" method="post">
    <label>comment</label>
    <input type="text" name="comment" required>
    <input type="submit">
    <br>
</form>
<a href=<?=$_SESSION["url"]?>>
    <button>Go back</button>
    <?php include "./snippets/footer.php";?>
