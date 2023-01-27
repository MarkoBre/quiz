<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../db/dbConfig.php');
require('../otacKlasa.php');
$signUpStatus = $_GET['signUp'];
if ($signUpStatus == "successful") {
    echo "bravo";
}

class Login extends User
{
    public static $emailErr;
    public static $passwordErr;
    public function verifyLogin($email, $password)
    {
        $passwordHash = '';
        $query = "SELECT email, passwordHash FROM login_information WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($email, $passwordHash);

        if ($stmt->fetch()) {
            if (password_verify($password, $passwordHash)) {
                return true;
            } else {
                Login::$passwordErr = "password";
                return false;
            }
        } else {
            Login::$emailErr = "email";
            return false;
        }
    }
}

if ( // Check if request method is post
    ($_SERVER['REQUEST_METHOD'] === 'POST') &&
    // Check if forms aren't empty
    isset ($_POST['email']) && !empty ($_POST['email']) &&
    isset ($_POST['password']) && !empty ($_POST['password']) &&
    isset ($_POST['login'])
) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = new Login($conn);

    $user->verifyLogin($email, $password);
}
?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz sign in</title>
    <link href="/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/css/general.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <h1 class="sign-in">Welcome to quiz for apes</h1>
        <h2 class="sign-in">Please sign in:</h2>
    </header>

    <main>

        <div class="form-container">
            <form id="myForm" action="login.php" method="post">
                <!-- Error message to be displayed
                when email is incorrect -->
                <span id="emailError" class="error">
                    <?php
                        if (Login::$emailErr == "email") {
                            echo "Incorrect email! :(";
                        }
                    ?>
                </span>
                <!-- Form for email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email:</label>
                    <input id="email" type="email" class="form-input"
                        name="email" placeholder="Enter your email address...">
                </div>
                <!-- Error message to be displayed
                when password is incorrect -->
                <span id="passwordError" class="error">
                    <?php
                        if (Login::$passwordErr == "password") {
                            echo "Incorrect password! :(";
                        }
                    ?>
                </span>
                <!-- Form for password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password:</label>
                    <input id="password" type="password" class="form-input"
                        name="password" placeholder="Enter your password...">
                    <a href="changePassword.php" class="forgot-password">Forgot password?</a>
                </div>
                <!-- Login button -->
                <div class="form-group">
                    <button id="submit "type="submit" name="submit" class="submit">Login</button><br />
                </div>

            </form>
            <!-- Create new account link -->
            <div class="create-account">
                <p>Don't have an account yet?</p>
                <a href="signUp.php">Sign up now!</a>
            </div>
        </div>

    </main>
    <script href="../js/validateLogin.js"></script>
</body>
</html>