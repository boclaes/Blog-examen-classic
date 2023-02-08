<?php
declare(strict_types=1);
require_once "../helpers.php";

$db = getLogin();

addBlog($db, $_POST["title"], $_POST["blog"]);
