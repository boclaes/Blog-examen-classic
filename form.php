<?php
include "./vendor/autoload.php";
include "./functions/helpers.php";
registerExceptionHandler();
session_start();
?>
<?php include "./snippets/header_main.php"; ?>
<form
        action="insert.php" method="post">
    <label>Title</label>
    <input type="text" name="title" required>
    <label>Text</label>
    <input type="text" name="blog" required>
    <input type="submit">
    <br>
</form>
<a href="welcome.php">
    <button>Go back</button>
<?php include "./snippets/footer.php";?>
