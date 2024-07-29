<?php
require_once("../db/conn.php");


$fullNameError = $usernameError = $emailError = $passwordError = '';
$insertSQL = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit"])) {

        $fullname = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST["fullname"]))));
        $username = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST["username"]))));
        $email = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST["email"]))));
        $password = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST["password"])));



        // VALIDATE FULLNAME
        if (empty($fullname)) {
            $fullNameError = "<p style='color:#dc3545;'>Full Name is required</p>";
            $insertSQL = false;
        } elseif (!preg_match('/^[a-zA-Z ]+$/', $fullname)) {
            $fullNameError = "<p style='color:#dc3545;'>Full Name should only contain alphabetic characters</p>";
            $insertSQL = false;
        } elseif (strlen($fullname) < 15) {
            $fullNameError = "<p style='color:#dc3545;'>Please fill in the field with at least 15 characters!</p>";
            $insertSQL = false;
        }


        // EMAIL USERNAME
        if (empty($username)) {
            $usernameError = "<p style='color:#dc3545;'>Username is required</p>";
            $insertSQL = false;
        } elseif(strlen($username) <= 8) {
            $usernameError = "<p style='color:#dc3545;'>Please fill in the field with more than 8 Character!</p>";
            $insertSQL = false;
        }



        // EMAIL VALIDATE
        if (empty($email)) {
            $emailError = "<p style='color:#dc3545;'>E-mail is required</p>";
            $insertSQL = false;
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $emailError = "<p style='color:#dc3545;'>Please Write Correct Email</p>";
            $insertSQL = false;
        }
        // Check Email already exists

        else {

            $selectUsername = "SELECT username FROM register WHERE username = '$username' LIMIT 1";
            $resUsername = mysqli_query($conn, $selectUsername);
            $selectEmailFromWorkers = "SELECT email FROM workers WHERE email = '$email' LIMIT 1";
            $selectEmailFromRegister = "SELECT email FROM register WHERE email = '$email' LIMIT 1";
            $selectEmail = "($selectEmailFromWorkers) UNION ($selectEmailFromRegister) ";
            $res = mysqli_query($conn, $selectEmail);

            if (mysqli_num_rows($res) > 0) {
                $emailError = "<p style='color:#dc3545;'>Email already exists</p>";
                $insertSQL = false;
            } elseif (mysqli_num_rows($resUsername) > 0) {
                $usernameError = "<p style='color:#dc3545;'>Username already exists</p>";
                $insertSQL = false;
            }
        }


        // VALIDATE PASSWORD
        if (empty(trim($password))) {
            $passwordError = "<p style='color:#dc3545;'>Password is required</p>";
            $insertSQL = false;
        } elseif (mb_strlen($password) < 8) {
            $passwordError = "<p style='color:#dc3545;'>Please fill in the field with more than 8 characters!</p>";
            $insertSQL = false;
        }




        // INSERTION DATABASE
        if ($insertSQL) {
            $query = "INSERT INTO register(fullname, username, email, password) VALUES('$fullname','$username', '$email' , '" . hash('sha256', $password) . "')";
            $result = mysqli_query($conn, $query);
            header("Location: login.php");
        } else {
            echo "<script>alert('DATA NO INSERT')</script>";
        }
    }
}


// Close the database connection
mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS File -->
    <link rel="stylesheet" href="style.css">
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Register User</title>
</head>

<body>
    <div class="icon">
        <i class="fa-solid fa-sun" id="icon"></i>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="content__form">

            <div class="primary__title" role="tab">
                <h1>Welcome To
                    <div class="logo" role="logo">
                        <h2><span>nQawa</span> Services</h2>
                    </div>
                </h1>
            </div>


            <label for="fullname">full name</label>

            <span><?php echo $fullNameError; ?></span>
            <input type="text" name="fullname" id="fullname" placeholder="Full Name" value="<?php if (isset($_POST['fullname'])) {
                                                                                                echo $_POST['fullname'];
                                                                                            } ?>">


            <label for="username">username</label>
            <span><?php echo $usernameError; ?></span>
            <input type="text" name="username" id="username" placeholder="Username" value="<?php if (isset($_POST['username'])) {
                                                                                                echo $_POST['username'];
                                                                                            } ?>">

            <label for="email">E-mail</label>
            <span><?php echo $emailError; ?></span>
            <input type="text" name="email" id="email" placeholder="Email Address" value="<?php if (isset($_POST['email'])) {
                                                                                                echo $_POST['email'];
                                                                                            } ?>">

            <label for="password">password</label>
            <span><?php echo $passwordError; ?></span>
            <input type="password" name="password" id="password" placeholder="Password">


            <button type="submit" value="register" name="submit" style=" padding: 10px 30px !important;">Register Now</button>
            <p>Already Have an account? <a href="login.php">Login</a></p>
        </div>

    </form>

    <script src="../JS/index.js"></script>
</body>

</html>