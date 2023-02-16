<?php
require_once "../helpers.php";

$db = getDBLogin();

$x = getLikes($db, $_SESSION["id"], $_POST["blog_id"]);

list($x_user_id, $x_blog_id) = $x[0];

addLike($db, $x_user_id, $x_blog_id, $_SESSION["id"], $_POST["blog_id"]);
