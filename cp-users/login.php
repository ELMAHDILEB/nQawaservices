<?php
require_once("../db/conn.php");
session_start();
if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {
    // active session direct the user to the appropriate page
    header('location: edit-account.php');
    exit();
} else {

    $usernameError = $passwordError = $errorMsg =  '';


    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {


        $username = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['username'])));
        $password = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['password'])));

        if (empty(trim($username))) {
            $usernameError = "<p style='color:#dc3545;'>Username is required</p>";
        }
        if (empty(trim($password))) {
            $passwordError = "<p style='color:#dc3545;'>Password is required</p>";
        }


        $selectUser = "SELECT * FROM register WHERE username = '$username' and password = '" . hash('sha256', $password) . "'";
        $execute = mysqli_query($conn, $selectUser);
        $rows = mysqli_fetch_assoc($execute);

        if ($rows) {
            $_SESSION['idUser'] = $rows['id'];
            $_SESSION['fullname'] = $rows['fullname'];
            $_SESSION['type'] = $rows['type'];
            if ($rows['type'] == 'user') {
                header('location:edit-account.php');
            } else {
                header('location: register.php');
            }
        } else {
            $errorMsg = "<p style='color:#dc3545;'>Error Username or Password </p>";
        }
    }
}
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
    <title>Login User</title>
</head>

<body>
    <div class="icon">
        <i class="fa-solid fa-sun" id="icon"></i>
    </div>
    <form action="" method="post">
        <div class="content__form">

            <div class="primary__title" role="tab">
                <h1>Welcome User
                    <div class="logo" role="logo">
                        <h2><span>nQawa</span> Services</h2>
                    </div>
                </h1>
            </div>


            <span><?php echo $errorMsg; ?></span>
            <label for="username">username</label>
            <span><?php echo $usernameError; ?></span>
            <input type="text" name="username" id="username" placeholder="Username" value="<?php if (isset($_POST['username'])) {
                                                                                                echo $_POST['username'];
                                                                                            } ?>">
            <label for="password">password</label>
            <span><?php echo $passwordError; ?></span>
            <input type="password" name="password" id="password" placeholder="Password">
            <button type="submit" value="login" name="submit">Login</button>
            <p>Don't have an account yet? <a href="register.php">Sign Up</a></p>
        </div>

    </form>
    <script src="../JS/index.js"></script>
</body>

</html>