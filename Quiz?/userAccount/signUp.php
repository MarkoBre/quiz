<?php
ob_start();
require('../db/dbConfig.php');
require('../otacKlasa.php');
class Signup extends User
{
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function checkData()
    {
        $email = $this->test_input($_POST['email']);
        $password = $this->test_input($_POST['password']);
        $username = $this->test_input($_POST['username']);
        $day = $this->test_input($_POST['day']);
        $month = $this->test_input($_POST['month']);
        $year = $this->test_input($_POST['year']);

        if (
            ($_SERVER['REQUEST_METHOD'] === 'POST') &&
            isset($_POST['submit']))
        {
            // Checks if there are empty forms
            // and if they follow regex rules
            if (empty($username) || !preg_match("/^[a-zA-Z0-9._]{4,20}$/", $username)) {
                $this->errors['usernameError'] = "Please enter a valid username";
                return true;
            }
            if (empty($password) || !preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $password)) {
                $this->errors['passwordError'] = "Please enter a valid password";
                return true;
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors['emailError'] = "Please enter a valid email";
                return true;
            }
            if (empty($day) || $day <= 0 || $day > 31 ) {
                $this->errors['dayError'] = "*";
                return true;
            }
            if (empty($month) || $month <= 0 || $month > 12) {
                $this->errors['monthError'] = "*";
                return true;
            }
            if (empty($year) || $year <= 1922 || $year >= 2021) {
                $this->errors['yearError'] = "*";
                return true;
            }
        }
    }

    public function createAccount($username, $email, $password, $day, $month, $year)
    {
        if (
            ($_SERVER['REQUEST_METHOD'] === 'POST') &&
            isset($_POST['submit']))
        {
            if (empty($this->errors)) {
                // Fill in properties with user data
                $this->username = $username;
                $this->email = $email;
                $this->password = password_hash($password, PASSWORD_BCRYPT);
                $dob = $year . "-" . $month . "-" . $day;
                $this->dob = date("Y-m-d", strtotime($dob));
                /*
                 * Prepare and execute the query to insert
                 * new users data into mySQL database
                 */
                $query = "INSERT INTO login_information (email, passwordHash, dateOfBirth, username) VALUES (?, ?, ?, ?)";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("ssss", $this->email, $this->password, $this->dob, $this->username);
                $stmt->execute();

                if (mysqli_affected_rows($this->conn) > 0){
                    $this->conn->close();
                    header("Location: login.php?signUp=successful", true, 301);
                    ob_end_flush();
                    exit();
                }
            }
        }
    }
}
?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz sign up</title>
    <link href="/css/reset.css" rel="stylesheet" type="text/css">
    <link href="/css/general.css" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <h1 class="sign-in">Join us now to check how strong is your autism</h1>
        <h2 class="sign-in">Create an account:</h2>
    </header>
    <main>

        <div class="form-container">
            <form id="myForm" action="../userAccount/signUp.php" method="post">

                <!-- Error message to be displayed when username is invalid -->
                <span id="usernameError" class="error"></span>
                <!-- Form for username -->
                <div class="form-group">
                    <label for="username" class="form-label">Username:</label>
                    <!-- Username input field with validation rules -->
                    <input id ="username" type="text" class="form-input" name="username"
                        placeholder="Choose your username..."
                        pattern="^[a-zA-Z0-9._]{4,20}$"
                        title="4-20 chars, letters, digits, dots, and underscores only"
                        required >
                    </div>

                <!-- Error message to be displayed when email is invalid -->
                <span id="emailError" class="error"></span>
                <!-- Form for email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email:</label>
                    <!-- Email input field with validation rules -->
                    <input id="email" type="email" class="form-input" name="email"
                        placeholder="Choose your email address..."
                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        title="Please Enter a Valid Email Address"
                        required >
                </div>

                <!-- Error message to be displayed when password is invalid -->
                <span id="passwordError" class="error"></span>
                <!-- Form for password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-input" name="password"
                        placeholder="Choose your password..."
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Must have 1 digit, 1 uppercase, 1 lowercase letter and 8 characters min"
                        id= "password" required >
                </div>

                <!-- Form for DoB day -->
                <div class="dob-container">
                    <span id="dayError" class="error"></span>
                    <label for="day">Day:</label>
                    <input type="number" id="day" name="day"
                        placeholder="DD" min="1" max="31" required >

                    <!-- Form for DoB month -->
                    <span id="monthError" class="error"></span>
                    <label for="month">Month:</label>
                    <select id="month" name="month">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>

                    <!-- Form for DoB year -->
                    <span id="yearError" class="error"></span>
                    <label for="year">Year:</label>
                    <input type="number" id="year" name="year"
                        placeholder="YYYY" min="1923" max="2020" required >
                </div>

                <div class="form-group">
                    <button id="submit" type="submit" name="submit" class="submit">Sign up</button><br />
                    <?php
                    if (
                        ($_SERVER['REQUEST_METHOD'] === 'POST') &&
                        isset($_POST['submit']))
                    {
                        $newUser = new Signup($conn);

                        if (!$newUser->checkData()) {
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $username = $_POST['username'];
                            $day = $_POST['day'];
                            $month = $_POST['month'];
                            $year = $_POST['year'];

                            $newUser->createAccount($username, $email, $password, $day, $month, $year);
                        }
                    }
                    ?>
                </div>

            </form>
        </div>

    </main>
    <script src="../js/validateSignup.js"></script>
</body>
</html>