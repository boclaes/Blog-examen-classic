<?php
declare(strict_types=1);
require_once "../../database/connection.php";
session_start();

$comment = htmlspecialchars($_POST["comment"]);
print_r($_SESSION["url"]);

$sql = "INSERT INTO comments (id_blog, author, text) VALUES (:id_blog_comment, :author, :comment)";

if ($stmt = $pdo->prepare($sql)) {
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":id_blog_comment", $_SESSION["id_blog_comment"], PDO::PARAM_STR);
    $stmt->bindParam(":author", $_SESSION["email"], PDO::PARAM_STR);
    $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to login page
        header("location:". $_SESSION["url"]);
    } else {
        echo "Oops! Something went wrong. Please try again later.";
        echo "<a href='../../index.php'><button>Go back</button></a>";
    }

// Close statement
    unset($stmt);

// Close connection
    unset($pdo);
}