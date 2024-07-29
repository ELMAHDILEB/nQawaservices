<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['idWorker']) && !empty($_SESSION['idWorker'])) {
    header('location: ../cp-team/index.php?page=panel-team');
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


        $selectWorker = "SELECT * FROM workers WHERE username = '$username' and password = '" . hash('sha256', $password) . "' ";
        $execute = mysqli_query($conn, $selectWorker);

        if ($execute && mysqli_num_rows($execute) > 0) {
            $rows = mysqli_fetch_assoc($execute);
            $type = $rows['type'];
            $status = $rows['status'];
            // $_SESSION['type'] = $rows['type'];
            // $_SESSION['fullname'] = $rows['fullname'];



            if ($type == 'admin') {
                $_SESSION['idWorker'] = $rows['id'];
                $_SESSION['type'] = $rows['type'];
                $_SESSION['fullname'] = $rows['fullname'];
                header('location: ../cp-admin/index.php?page=dashboard');
                exit();
            } else {
                if ($status == 'accept') {
                    $_SESSION['idWorker'] = $rows['id'];
                    $_SESSION['type'] = $rows['type'];
                    $_SESSION['fullname'] = $rows['fullname'];
                    header('location: ../cp-team/index.php?page=panel-team');
                    exit();
                } elseif ($status == 'in progress') {
                    session_unset();
                    session_destroy();
                    echo "<script>alert('Please wait for membership acceptance, then a message will be sent to your email')</script>";
                }
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
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS File -->
    <!-- <link rel="stylesheet" href="style.css"> -->
    <style>
        :root {
            --color-text: #fff;
            --color-black: black;
            --color-first: #2ebbd4;
            --color-second: #e7e7e7;
            --color-hover: #75d2e3;
            --hover-two: #75d2e380;
            --color-box: #dcdcdc;
            --filter: invert(0%);
            --color-mobile: rgba(0, 0, 0, 0.8);
            --color-logo: #4FC6DB;
            --color-i: #202020;

        }

        .dark__theme {
            --color-i: #a0a0a0;
            --color-text: rgb(0, 0, 0);
            --color-black: #fff;
            --color-first: #0e1319;
            --color-second: rgb(0, 0, 0);
            --color-hover: #1f2936;
            --color-box: #0e1319;
            --filter: invert(100%);
            --color-mobile: rgba(255, 255, 255, 0.8);
            --color-logo: #58789e;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-color: var(--color-second);
            position: relative;
            height: 100dvh;
        }

        .icon {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            background-color: var(--color-box);
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            right: 5%;
            top: 1%;
        }

        .icon>i {
            width: 60%;
            object-fit: cover;
            transition: 1s ease-in-out;
            text-align: center;
            filter: var(--filter);
            -webkit-filter: var(--filter);
            cursor: pointer !important;
        }

        form {
            width: 100%;
            height: 100%;
            background-color: var(--color-second);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content__form {
            width: 700px;
            height: 600px;
            background-color: var(--color-box);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .primary__title {
            font-size: 14px;
            color: var(--color-black);
            text-transform: capitalize;
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 21px;
            text-transform: capitalize;
        }

        .logo span {
            color: var(--color-logo);
        }

        .content__form label {
            text-transform: capitalize;
            font-size: 16px;
            font-weight: unset;
            color: var(--color-black);
            margin-bottom: 5px;
        }

        .content__form input {
            width: 300px;
            height: 30px;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
        }

        .content__form button {
            padding: 10px 30px;
            border-radius: 22px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: 400;
            background: linear-gradient(to right,
                    var(--color-first) 50%,
                    var(--color-hover) 50%) left;
            background-size: 200%;
            transition: 0.5s ease-out;
            cursor: pointer;
            border: none;
            margin-bottom: 10px;
        }

        .content__form button:hover {
            background-position: right;
        }

        .content__form p {
            color: var(--color-black);
        }


        @media (max-width:310px) {
            .primary__title {
                font-size: 10px;

            }

            .logo {
                font-size: 15px;
            }

            .content__form label {
                font-size: 12px;
            }

            .content__form input {
                width: 210px;
            }

            .content__form p {
                font-size: 12px;
            }
        }
    </style>
    <title>Login User</title>
</head>

<body>
    <div class="icon">
        <i class="fa-solid fa-sun" id="icon"></i>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="content__form">

            <div class="primary__title" role="tab">
                <h1>Welcome Worker
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
            <!-- <p>Don't have an account yet? <a href="register.php">Sign Up</a></p> -->
        </div>

    </form>
    <script src="../JS/index.js"></script>
</body>

</html>