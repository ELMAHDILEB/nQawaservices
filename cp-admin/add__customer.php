<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {

    $userNameError = $fullNameError = $emailError = $passwordError = '';
    $insertSQL = true;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {


        $username = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['username']))));
        $fullname = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['fullname']))));
        $email = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['email']))));
        $password = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['password']))));




        if (!empty($fullname) && !empty($username)  && !empty($email) && !empty($password)) {


            // Validate Input User Name Input and check username is exists or non
            
            $selectUsername = "SELECT username FROM workers WHERE username = '$username' 
               UNION 
               SELECT username FROM register WHERE username = '$username'";

            // Execute the query
            $resUser = mysqli_query($conn, $selectUsername);

            // Check for existing username
            if (mysqli_num_rows($resUser) > 0) {
                $userNameError = "<p class='msgError'>Username already exists</p>";
                $insertSQL = false;
            } elseif (strlen($username) < 8) {
                $userNameError = "<p class='msgError'>Please fill in the field with more than 8 Character!</p></p>";
                $insertSQL = false;
            }
            // Validate Input Full Name Input
            if (!preg_match('/^[a-zA-Z ]+$/', $fullname)) {
                $fullNameError = "<p class='msgError''>full name should only contain alpha characters</p>";
                $insertSQL = false;
            }

            // Validate Email Input and EMAIL IS EXISTS OR NO
            
            $selectEmail = "SELECT email FROM workers WHERE email = '$email' 
               UNION 
               SELECT email FROM register WHERE email = '$email'";

            // Execute the query
            $res = mysqli_query($conn, $selectEmail);

            // Check for existing email
            if (mysqli_num_rows($res) > 0) {
                $emailError = "<p class='msgError'>Email already exists</p>";
                $insertSQL = false;
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
                $emailError = "<p class='msgError'>Please Write Correct Email</p>";
                $insertSQL = false;
            }

            if ($insertSQL) {
                $query = "INSERT INTO register (fullname, username ,email, password) VALUES ( '$fullname', '$username'  , '$email' , '" . hash('sha256', $password) . "')";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    echo "<script>alert('Data Insert Successfully');</script>";
                    echo "<script>window.location = 'index.php?page=customer';</script>";
                } else {
                    echo "<script>alert('Failed to insert data');</script>";
                }
            } 
        } else {
            echo "<script>alert('All Input Has Empty');</script>";
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
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");


        :root {
            --color-black: rgb(0, 0, 0);
            --color-second: #e7e7e7;
            --color-box: #dcdcdc;
        }

        .dark__theme {
            --color-black: #fff;
            --color-second: rgb(0, 0, 0);
            --color-box: #0e1319;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;

            font-family: "Poppins", sans-serif;
        }

        body {
            width: 100%;
            background-color: #e7e7e7;
        }

        .container {
            width: 100%;
            padding: 2%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px;
        }

        .container h1 {
            font-size: clamp(18px, 5vw, 25px);
            text-transform: capitalize;
        }

        .container form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .container form label {
            font-size: clamp(11px, 2vw, 14px);
        }

        .container form input {
            width: 300px;
            height: 30px;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
            transition: all 0.5s ease-in-out;
        }

        .container form input:focus {
            box-shadow: 0px 0px 2px 3px rgb(0, 0, 0, 10%);
        }

        .container form button {
            padding: 10px 14px;
            border-radius: 22px;
            color: black;
            text-decoration: none;
            font-size: clamp(11px, 3vw, 16px);
            font-weight: 400;
            background-color: #2ebbd4;
            cursor: pointer;
            border: none;
            outline: none;
        }

        

        

        .msgError {
            font-size: clamp(10px, 2vw, 16px);
            font-weight: 500;
            text-transform: capitalize;
            color: red;
        }

        @media screen and (max-width:339px) {
            .container form input {
                width: 200px;
            }

        }
    </style>
    <title>Add User</title>
</head>

<body>
    <div class="container">
        <h1>Add New Customer :</h1>
        <form action="" method="post">
            <!-- FuLL NAME -->
            <label for="fullname">Full Name :</label>
            <span><?php echo $fullNameError; ?></span>
            <input type="text" name="fullname" id="fullname" placeholder="John Deo" value="<?php if (isset($fullname)) {
                                                                                                echo $fullname;
                                                                                            } ?>" />

            <!-- USER NAME -->
            <label for="username">Username :</label>
            <span><?php echo $userNameError; ?></span>
            <input type="text" name="username" id="username" placeholder="John Deo" value="<?php if (isset($username)) {
                                                                                                echo $username;
                                                                                            } ?>" />

            <!-- EMAIL -->
            <label for="email">E-mail :</label>
            <span><?php echo $emailError; ?></span>
            <input type="email" name="email" id="email" placeholder="john.deo@mail.com" value="<?php if (isset($email)) {
                                                                                                    echo $email;
                                                                                                } ?>" />

            <!-- PASSWORD -->
            <label for="password">Password :</label>
            <span><?php echo $passwordError; ?></span>
            <input type="password" name="password" id="password" value="<?php if (isset($password)) {
                                                                            echo $password;
                                                                        } ?>" />





            <button type="submit" name="submit">Add Customer</button>
        </form>
    </div>
</body>

</html>