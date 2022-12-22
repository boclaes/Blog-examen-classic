<?php
// Initialize the session
session_start();
include "./vendor/autoload.php";
include "./functions/helpers.php";
require_once "./database/connection.php";
registerExceptionHandler();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM users WHERE email = :email";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if email exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $email = $row["email"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid email or password.";
                        }
                    }
                } else{
                    // email doesn't exist, display a generic error message
                    $login_err = "Invalid email or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>

<?php include "./snippets/header_login.php"; ?>
<body>
<div class="wrapper">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>

    <?php
    if(!empty($login_err)){
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label>email</label>
            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>
<?php include "./snippets/footer.php"; ?>