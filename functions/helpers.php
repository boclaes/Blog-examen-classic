<?php
declare(strict_types=1);
session_start();

function dbConnect(string $user, string $pass, string $db, string $host = 'localhost'): PDO
{
    $connection = new PDO("mysql:host={$host};dbname={$db}", $user, $pass);

    return $connection;
}

function getDBLogin(): PDO
{
    $db = dbConnect(
        user: 'bo',
        pass: 'telenet0976',
        db: 'test_2',
    );
    return $db;
}

function getBlog(PDO $db): array{
    $res = $db->query("select * from blogs");
    return $res->fetchAll();
}

function getBlogAndLikes(PDO $db){
    $res = $db->query("select * from blogs LEFT OUTER JOIN likes ON likes.blog_id = blogs.id");
    $stmt = $res->fetchAll();
    foreach ($stmt as $likes){
        if($likes["likes"] < 1){
            return true;
        }
        else{
            return false;
        }
    }
}


function getEdit(PDO $db, int $id): array{
    $res = $db->prepare("SELECT title, text FROM blogs WHERE id = :id");
    $res->bindParam('id', $id, PDO::PARAM_INT);
    $res->execute();
    return $res->fetchAll();
}

function getDetails(PDO $db, $id): array{
    $res = $db->prepare("SELECT title, author, text, created_at  FROM blogs WHERE id=:id");
    $res->bindParam('id', $id, PDO::PARAM_INT);
    $res->execute();
    return $res->fetchAll();
}

function getComments(PDO $db, $id): array{
    $res = $db->prepare("SELECT id, id_blog, author, text, status  FROM comments WHERE id_blog=:id");
    $res->bindParam('id', $id, PDO::PARAM_INT);
    $res->execute();
    return $res->fetchAll();
}

function getLikesDetails(PDO $db, $id): array{
    $res = $db->prepare("SELECT blog_id, likes  FROM likes WHERE blog_id=:id");
    $res->bindParam('id', $id, PDO::PARAM_INT);
    $res->execute();
    return $res->fetchAll();
}


function getLikes(PDO $db, $user_id, $blog_id): array{
    $res = $db->prepare("SELECT user_id, blog_id FROM likes WHERE user_id = :user_id AND blog_id = :blog_id ");
    $res->bindParam(":user_id", $user_id, PDO::PARAM_STR);
    $res->bindParam(":blog_id", $blog_id, PDO::PARAM_STR);
    $res->execute();
    return $res->fetchAll();
}

function getLogin(PDO $db, $param_email, $password){
    $res = $db->prepare("SELECT id, email, password FROM users WHERE email = :email");
    $res->bindParam(":email", $param_email, PDO::PARAM_STR);
    $res->execute();
    if ($res->rowCount() == 1) {
        if ($row = $res->fetch()) {
            $id = $row["id"];
            $email = $row["email"];
            $hashed_password = $row["password"];
            if (password_verify($password, $hashed_password)) {

                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["email"] = $email;

                // Redirect user to welcome page
                header("location: ../../index.php");
            } else {
                // Password is not valid, display a generic error message
                return "Invalid email or password.";
            }
        } else {
            // email doesn't exist, display a generic error message
            return "Invalid email or password.";
        }
    } else {
        return "Invalid email or password.";
    }
}

function addBlog(PDO $db, string $title, string $blog): void{

    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $blog = htmlspecialchars($blog, ENT_QUOTES, 'UTF-8');

    $res = $db->prepare("INSERT INTO blogs (title, author, text) VALUES (:title, :author, :blog)");
    $res->bindParam('title', $title);
    $res->bindParam('author', $_SESSION["email"]);
    $res->bindParam('blog', $blog);
    $res->execute();

    header("location: ../../index.php");
}

function edit(PDO $db, string $title, string $blog): void{

    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $blog = htmlspecialchars($blog, ENT_QUOTES, 'UTF-8');

    $res = $db->prepare("UPDATE blogs SET title = :title, text = :blog WHERE id = :id");
    $res->bindParam(":title", $title, PDO::PARAM_STR);
    $res->bindParam(":blog", $blog, PDO::PARAM_STR);
    $res->bindParam(":id", $_POST["id"], PDO::PARAM_STR);
    $res->execute();

    header("location: ../../index.php");
}


function comment(PDO $db, $id_blog_comment, $author, $url, string $comment): void{

    $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

    $res = $db->prepare("INSERT INTO comments (id_blog, author, text) VALUES (:id_blog_comment, :author, :comment)");
    $res->bindParam(":id_blog_comment", $id_blog_comment, PDO::PARAM_STR);
    $res->bindParam(":author", $author, PDO::PARAM_STR);
    $res->bindParam(":comment", $comment, PDO::PARAM_STR);
    $res->execute();

    header("location:". $url);
}


function addLike(PDO $db, $x_user_id, $x_blog_id, $user_id, $blog_id ): void{

    $like_counter = 1;

    if ($x_user_id == $user_id && $x_blog_id == $blog_id){
        $res = $db->prepare("DELETE FROM likes WHERE user_id = :user_id AND blog_id = :blog_id");
        $res->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $res->bindParam(":blog_id", $blog_id, PDO::PARAM_STR);
    }
    else {
        $res = $db->prepare("INSERT INTO likes (user_id, blog_id, likes) VALUES (:user_id, :blog_id, :likes)");
        $res->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $res->bindParam(":blog_id", $blog_id, PDO::PARAM_STR);
        $res->bindParam(":likes", $like_counter, PDO::PARAM_STR);

    }
    $res->execute();
    header("location: ../../index.php");
}



function deleteBlog(PDO $db): void
{

    $now = date('y-m-d H:i:s');
    $zero = 0;

    $res = $db->prepare("UPDATE blogs SET deleted_at = :now WHERE id = :id");
    $res->bindParam('now', $now);
    $res->bindParam('id', $_POST['id']);
    $res->execute();

    $res_2 = $db->prepare("UPDATE blogs SET status = :zero WHERE id = :id");
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

/*
function checkEmail($email): string
{
    if (empty($email)) {
        return "Please enter email.";
    } else {
        return trim($_POST["email"]);
    }
}

function checkPass($pass): string
{
    if (empty($pass)) {
        return "Please enter password.";
    } else {
        return trim($_POST["password"]);
    }
}
*/


function checkDuplicateEmail($db, $param_email){

    $res = $db->prepare("SELECT id FROM users WHERE email = :email");
    $res->bindParam(":email", $param_email, PDO::PARAM_STR);
    $res->execute();
    if ($res->rowCount() == 1) {
        return "This email is already taken.";
    }
}


function checkDuplicateUsername ($db, $param_username){
    $res = $db->prepare("SELECT id FROM users WHERE username = :username");
    $res->bindParam(":username", $param_username, PDO::PARAM_STR);
    $res->execute();
    if ($res->rowCount() == 1) {
        return "This username is already taken.";
    }
}


function insertRegistration($db, $param_email, $param_username, $param_password): void{

    $res = $db->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
    $res->bindParam(":email", $param_email, PDO::PARAM_STR);
    $res->bindParam(":username", $param_username, PDO::PARAM_STR);
    $res->bindParam(":password", $param_password, PDO::PARAM_STR);
    $res->execute();
    header("location: login.php");
}