<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {
    $typeError = $userNameError = $fullNameError = $emailError = $passwordError = '';
    $insertSQL = true;
    // SELECT DATA

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT * FROM register WHERE id = '$id'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $type = $row['type'];
            // $username = $row['username'];
            $fullname = $row['fullname'];
            $email = $row['email'];
        } else {
            echo "<script>alert('user ID is not provided.')</script>";
            header("Location: index.php?page=customer");
            exit();
        }
    } else {
        header("Location: index.php?page=customer");
        die();
    }


    // UPDATE DATA

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

        $allowType = ['admin','leader','worker','user'];
        $type = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['type']))));
        $fullname = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['fullname']))));
        $email = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['email']))));
        $password = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['password']))));

       



        if (!empty($type) &&  !empty($fullname) ) {

            // Validate A type  Input
            if (!in_array($type, $allowType)) {
                $typeError = "<p class='msgError'>Please select one type admin - leader - worker - user!</p>";
                $insertSQL = false;
            }

            // Validate Input Full Name Input
            if (!preg_match('/^[a-zA-Z ]+$/', $fullname)) {
                $fullNameError = "<p class='msgError''>full name should only contain alpha characters</p>";
                $insertSQL = false;
            }

            // Validate Email Input and EMAIL IS EXISTS OR NO
            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
                $emailError = "<p class='msgError'>Please Write Correct Email</p>";
                $insertSQL = false;
            } elseif (!empty($email) && $email !== $row['email']) {
                $selectEmailFromWorkers = "SELECT email FROM workers WHERE email = '$email' LIMIT 1";
                $selectEmailFromRegister = "SELECT email FROM register WHERE email = '$email' LIMIT 1";
                $selectEmail = "($selectEmailFromWorkers) UNION ($selectEmailFromRegister)";
                $res = mysqli_query($conn, $selectEmail);
            
                if (mysqli_num_rows($res) > 0) {
                    $emailError = "<p class='msgError'>Email already exists</p>";
                    $insertSQL = false;
                }
            }


            if ($insertSQL) {
                if(!empty($password)){
                    $sql = "UPDATE register SET type = '$type', fullname = '$fullname', email = '$email', password = '" . hash('sha256', $password) . "'  WHERE `id` = '$id'";
                $rsl = mysqli_query($conn, $sql);
                }else{
                    $sql = "UPDATE register SET type = '$type',  fullname = '$fullname', email = '$email'  WHERE `id` = '$id'";
                $rsl = mysqli_query($conn, $sql);
                }

                if ($rsl) {
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
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            font-size: 16px;
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
            font-size: clamp(10px, 2vw, 16px);
            padding: 10px 14px;
            border-radius: 22px;
            color: black;
            text-decoration: none;
            font-weight: 500;
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
    </style>
    <title>Add User</title>
</head>

<body>
    <div class="container">
        <h1>Edit Customer :</h1>
        <form action="" method="post">

            <!-- Type  -->
            <label for="type">Select Type User :</label>
            <span><?php echo $typeError; ?></span>
            <input type="text" name="type" id="type" placeholder="Admin-leader..." value="<?php if(isset($type)){echo $type;}?>">


            <!-- USER NAME -->
            <!-- <label for="username">Username :</label>
            <span><?php echo $userNameError; ?></span>
            <input type="text" name="username" id="username" placeholder="John Deo" value="<?php if (isset($username)) {
                                                                                                echo $username;
                                                                                            } ?>" /> -->

            <!-- FuLL NAME -->
            <label for="fullname">Full Name :</label>
            <span><?php echo $fullNameError; ?></span>
            <input type="text" name="fullname" id="fullname" placeholder="John Deo" value="<?php if (isset($fullname)) {
                                                                                                echo $fullname;
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
            <input type="password" name="password" id="password" value="" />


            <button type="submit" name="submit"><i class="fa-solid fa-pen-to-square"></i> &nbsp Edit Customer </button>
        </form>
    </div>
</body>

</html>