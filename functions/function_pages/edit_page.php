<?php
declare(strict_types=1);
session_start();
require_once "../../database/connection.php";

$title = htmlspecialchars($_POST["title"]);
$blog = htmlspecialchars($_POST["blog"]);

$sql = "UPDATE todos SET title = :title, text = :blog WHERE id = :id";

if($stmt = $pdo->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":blog", $blog, PDO::PARAM_STR);
    $stmt->bindParam(":id", $_SESSION["id_edit"], PDO::PARAM_STR);


    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Redirect to login page
        header("location: ../../index.php");
    } else{
        echo "Oops! Something went wrong. Please try again later.";
        echo "<a href='../../index.php'>";
        echo "<button>Go back</button>";
    }

// Close statement
    unset($stmt);

// Close connection
    unset($pdo);
}
