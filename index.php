<?php
// Initialize the session
include "functions/helpers.php";

$db = getDBLogin();
$stmt = getBlog($db);
$test = getBlogAndLikes($db);

var_dump($test);

?>

<?php include "./snippets/header_main.php" ?>
<div id="container">
    <h1 style="text-align: center">Blog posts</h1>
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

                <?php if ($row["status"] == 1 and (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)):?>
                    <td><a href="pages/details.php?id=<?=$row["id"];?>"><?=$row["title"];?></a></td>
                    <td><?=$row["text"]?></td>

                <?php elseif($row["status"] == 1 and $row["author"] == $_SESSION["email"]): ?>
                    <td><a href="pages/details.php?id=<?=$row["id"];?>"><?=$row["title"];?></a></td>
                    <td><?=$row["text"]?></td>
                    <td><form method="POST" action="functions/function_pages/delete.php"><input type="hidden" value= <?=$row['id']?> name="id"><input type="submit" value="Delete"></form></td>
                    <td><form method="POST" action="pages/edit.php"><input type="hidden" value= <?=$row['id']?> name="id"><input type="submit" value="edit"></form></td>

                <?php elseif($row["status"] == 1): ?>
                    <td><a href="pages/details.php?id=<?=$row["id"];?>"><?=$row["title"];?></a></td>
                    <td><?=$row["text"]?></td>
                    <td><form method="POST" action="functions/function_pages/like.php"><input type="hidden" value=<?=$row['id']?> name="blog_id"><input type="image" value="blog_id" src="images/icons8-thumbs-up-64.png" alt="like"></form></td>

                <?php elseif($row["status"] == 0 and (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)): ?>
                    <td> Not available anymore </td>

                <?php else: ?>
                    <td> Not available anymore </td>

            </tr>
        <?php endif; endforeach; ?>
        </tbody>
    </table>

    <?php if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true): ?>
    <a href='pages/login.php'>
        <button style="position:absolute;top:-1px;right:-1px;">login</button>
    <?php endif; ?>

    <?php if (isset($_SESSION["loggedin"])): ?>
    <button style="position: absolute; right: 48%" type="button" onclick="window.location.href='pages/form.php'">Add blog</button>
    <button style="position: absolute; top: 10px; right: 10px;">
        <a href="./functions/logout.php">Sign Out of Your Account</a>
    </button>
</div>
    <?php endif ?>

<?php include "./snippets/footer.php";?>
