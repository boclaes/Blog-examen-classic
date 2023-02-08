<?php
include "functions/helpers.php";

?>
<?php include "./snippets/header_main.php"; ?>
<form
    action="functions/function_pages/form_page.php" method="post">
    <label>Title</label>
    <input type="text" name="title" required>
    <label>Text</label>
    <input type="text" name="blog" required>
    <input type="submit">
    <br>
</form>
<a href="index.php">
    <button>Go back</button>
<?php include "./snippets/footer.php";?>
