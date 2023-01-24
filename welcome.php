<?php
// Initialize the session
session_start();
include "./vendor/autoload.php";
include "./functions/helpers.php";
require_once "./database/connection.php";
registerExceptionHandler();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$sql = "SELECT id, title, text, status FROM todos";

$stmt = $pdo->prepare($sql);
$stmt->execute();

?>

<?php include "./snippets/header_main.php" ?>
<div id="container">
    <h1>Blog posts</h1>
    <table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>Title</th>
            <th>Blog</th>
            <?php foreach($stmt as $row): ?>
        </tr>
        </thead>
        <tbody>
            <tr>
                <?php if ($row["status"] == 1):?>
                <td><a href="details.php?id=<?=$row["id"];?>"><?=$row["title"];?></a></td>
                <td><?=$row["text"]?></td>
                <td><form method="POST" action="delete.php"><input type="hidden" value= <?=$row['id']?> name="id"><input type="submit" value="Delete"></form></td>
                <td><form method="POST" action="edit.php"><input type="hidden" value= <?=$row['id']?> name="id"><input type="submit" value="edit"></form></td>
                <?php else: ?>
                <td> Not available anymore </td>
                <td><form method="POST" action="undo.php"><input type="hidden" value= <?=$row['id']?> name="id"><input type="submit" value="undo"></form></td>
            </tr>
        <?php endif; endforeach; ?>
        </tbody>
    </table>
    <a href="form.php">
        <button>Add Todo</button>
    <a href="test.php">
        <button>test page</button>
<?php include "./snippets/footer.php";?>
