<?php
declare(strict_types=1);
session_start();
include "database/connection.php";

$title = htmlspecialchars($_POST["title"]);
$blog = htmlspecialchars($_POST["blog"]);

$sql = "UPDATE todos SET title = :title, text = :blog";

if($stmt = $pdo->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":blog", $blog, PDO::PARAM_STR);

    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Redirect to login page
        header("location: index.php");
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

// Close statement
    unset($stmt);

// Close connection
    unset($pdo);
}
