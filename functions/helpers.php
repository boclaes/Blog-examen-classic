<?php
declare(strict_types=1);
include_once "./database/connection.php";
function registerExceptionHandler(): void{
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

/*
function form_upload($title, $blog): void{

    $sql = "INSERT INTO todos (title, author, text) VALUES (:title, :author, :blog)";

    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":author", $_SESSION["email"], PDO::PARAM_STR);
        $stmt->bindParam(":blog", $blog, PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to login page
            header("location: index.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
            echo "<a href='index.php'>";
            echo "<button>Go back</button>";
        }

// Close statement
        unset($stmt);

// Close connection
        unset($pdo);
    }
}
*/