<?php
declare(strict_types=1);
require_once "../helpers.php";


$db = getLogin();

deleteComment($db);