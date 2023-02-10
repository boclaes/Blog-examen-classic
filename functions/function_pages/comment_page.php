<?php
declare(strict_types=1);
require_once "../helpers.php";
session_start();

$db = getLogin();

comment($db, $_SESSION["id_blog_comment"], $_SESSION["email"],  $_SESSION["url"], $_POST["comment"] );