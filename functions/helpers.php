<?php
declare(strict_types=1);
include "./database/connection.php";
session_start();

function dbConnect(string $user, string $pass, string $db, string $host = 'localhost'): PDO
{
    $connection = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);

    return $connection;
}

function getLogin(): PDO
{
    $db = dbConnect(
        user: 'bo',
        pass: 'telenet0976',
        db: 'test_2',
    );
    return $db;
}

function getTodos(PDO $db): array{
    $res = $db->query("SELECT id, title, author, text, status FROM todos");
    return $res->fetchAll();
}

function getEdit(PDO $db, $id): array{
    $res = $db->query("SELECT title, text FROM todos WHERE id = :id");
    $res->bindParam('id', $id);
    return $res->fetchAll();
}

function getDetails(PDO $db, $id): array{
    $res = $db->query("SELECT title, author, text, created_at  FROM todos WHERE id=:id");
    $res->bindParam('id', $id);
    return $res->fetchAll();
}






function addBlog(PDO $db, string $title, string $blog): void{

    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $blog = htmlspecialchars($blog, ENT_QUOTES, 'UTF-8');

    $res = $db->prepare("INSERT INTO todos (title, author, text) VALUES (:title, :author, :blog)");
    $res->bindParam('title', $title);
    $res->bindParam('author', $_SESSION["email"]);
    $res->bindParam('blog', $blog);
    $res->execute();

    header("location: ../../index.php");
}

function edit(PDO $db, string $title, string $blog): void{

    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $blog = htmlspecialchars($blog, ENT_QUOTES, 'UTF-8');

    $res = $db->prepare("UPDATE todos SET title = :title, text = :blog WHERE id = :id");
    $res->bindParam(":title", $title, PDO::PARAM_STR);
    $res->bindParam(":blog", $blog, PDO::PARAM_STR);
    $res->bindParam(":id", $_SESSION["id_edit"], PDO::PARAM_STR);
    $res->execute();

    header("location: ../../index.php");
}





function deleteBlog(PDO $db): void
{

    $now = date('y-m-d H:i:s');
    $zero = 0;

    $res = $db->prepare("UPDATE todos SET deleted_at = :now WHERE id = :id");
    $res->bindParam('now', $now);
    $res->bindParam('id', $_POST['id']);
    $res->execute();

    $res_2 = $db->prepare("UPDATE todos SET status = :zero WHERE id = :id");
    $res_2->bindParam('zero', $zero);
    $res_2->bindParam('id', $_POST['id']);
    $res_2->execute();

    header("location: ../../index.php");
}

function deleteComment(PDO $db): void{
    $now = date('y-m-d H:i:s');
    $zero = 0;

    $res = $db->prepare("UPDATE comments SET deleted_at = :now WHERE id = :id");
    $res->bindParam('now', $now);
    $res->bindParam('id', $_POST['id']);
    $res->execute();

    $res_2 = $db->prepare("UPDATE comments SET status = :zero WHERE id = :id");
    $res_2->bindParam('zero', $zero);
    $res_2->bindParam('id', $_POST['id']);
    $res_2->execute();

    header("location:". $_SESSION["url"]);
}

