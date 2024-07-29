<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {
    $typeError = $userNameError = $fullNameError = $emailError = $passwordError = $numberPhoneError = $addressError = $cityError = $positionError = $workDayError = '';
    $insertSQL = true;
    // SELECT DATA

    if (isset($_GET['id'])) {
        $idWorker = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT * FROM workers WHERE idWorker = '$idWorker'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $type = $row['type'];
            $username = $row['username'];
            $fullname = $row['fullname'];
            $email = $row['email'];
            $numberPhone = $row['numberPhone'];
            $address = $row['address'];
            $city = $row['city'];
            $position = $row['position'];
            $workDays = $row['workDays'];
            $status = $row['status'];
        } else {
            echo "<script>alert('Worker ID is not provided.')</script>";
            sleep(3);
            header("Location: index.php?page=team");
            exit();
        }
    } else {
        header("Location: index.php?page=team");
        die();
    }


    // UPDATE DATA

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

        $allowType = ['admin', 'leader', 'worker'];
        $allowPosition = ['full time', 'part time', 'Full Time', 'Part Time'];
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $type = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['type']))));
        $username = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['username']))));
        $fullname = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['fullname']))));
        $email = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['email']))));
        $password = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['password']))));
        $numberPhone = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['numberPhone']))));
        $address = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['address']))));
        $city = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['city']))));
        $position = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['position']))));
        $workDays = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['workDays']))));
        $status = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['status']))));




        if (!empty($type) && !empty($username) && !empty($fullname) && !empty($email) &&  !empty($numberPhone) && !empty($address) && !empty($city) && !empty($position) && !empty($workDays)) {

            // Validate A type  Input
            if (!in_array($type, $allowType)) {
                $typeError = "<p class='msgError'>Please select one type Admin - Leader - Worker!</p>";
                $insertSQL = false;
            }

             // Validate Input User Name Input
             if (strlen($username) < 8) {
                $userNameError = "<p class='msgError'>Please fill in the field with more than 8 Character!</p></p>";
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
            // Validate Number Phone Input
            if (!ctype_digit($numberPhone)) {
                $numberPhoneError = "<p class='msgError' '>Please Write Correct Number Phone</p>";
                $insertSQL = false;
            }
            // Validate Address Input
            if (!preg_match('/^[a-zA-Z0-9 ]+$/', $address)) {
                $addressError = "<p class='msgError'>Address should only contain alphanumeric characters</p>";
                $insertSQL = false;
            }
            // Validate City Input
            if (!preg_match('/^[a-zA-Z ]+$/', $city)) {
                $cityError = "<p class='msgError''>City should only contain alpha characters</p>";
                $insertSQL = false;
            }
            // Validate Position Input
            if (!in_array($position, $allowPosition)) {
                $positionError = "<p class='msgError''>Please select one the position</p>";
                $insertSQL = false;
            }
            // Validate WorkDay Input
            $workDaysArray = explode(' - ', $workDays);
            foreach ($workDaysArray as $day) {
                $day = strtolower($day);
                if (!in_array($day, $days)) {
                    $workDayError = "<p class='msgError'>Please select valid Work Days</p>";
                    $insertSQL = false;
                    break;
                }
            }


            if ($insertSQL) {
                $hashedPassword = hash('sha256', $password);
                if(!empty($password)){
                    $sql = "UPDATE workers SET type = '$type', username = '$username',fullname = '$fullname', email = '$email', password = '$hashedPassword' , numberPhone = '$numberPhone', address = '$address', city = '$city', position = '$position', workDays = '$workDays', status = '$status' WHERE `idWorker` = '$idWorker'";
                $rsl = mysqli_query($conn, $sql);
                }else{
                    $sql = "UPDATE workers SET type = '$type', username = '$username',fullname = '$fullname', email = '$email',  numberPhone = '$numberPhone', address = '$address', city = '$city', position = '$position', workDays = '$workDays', status = '$status' WHERE `idWorker` = '$idWorker'";
                $rsl = mysqli_query($conn, $sql);
                }

                if ($rsl) {
                    echo "<script>alert('Data Update Successfully');</script>";
                    echo "<script>window.location = 'index.php?page=team';</script>";
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

        .status {
            border: none;
            outline: none;
            padding: 10px 14px;
            background: var(--color-box);
            color: var(--color-black);
            text-transform: capitalize;
        }


        .status option {
            text-transform: capitalize;
        }

        .container form button {
            font-size: clamp(10px, 2vw, 16px);
            padding: 10px 14px;
            font-weight: 400;
            text-decoration: none;
            color: black;
            border-radius: 22px;
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
        <h1>Edit User :</h1>
        <form action="" method="post">
            <label for="type">Select Type User :</label>
            <span><?php echo $typeError; ?></span>
            <input type="text" name="type" id="type" placeholder="Admin-leader..." value="<?php echo $type; ?>">

            <label for="username">Username :</label>
            <span><?php echo $userNameError; ?></span>
            <input type="text" name="username" id="username" placeholder="John Deo" value="<?php echo $username;?>" />

            <label for="fullname">Full Name :</label>
            <span><?php echo $fullNameError; ?></span>
            <input type="text" name="fullname" id="fullname" placeholder="John Deo" value="<?php echo $fullname; ?>" />

            <label for="email">E-mail :</label>
            <span><?php echo $emailError; ?></span>
            <input type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="user@example.com" />

            <label for="password">Password :</label>
            <span><?php echo $passwordError; ?></span>
            <input type="password" name="password" id="password" value="" />

            <label for="numberPhone">Number Phone :</label>
            <span><?php echo $numberPhoneError; ?></span>
            <input type="text" name="numberPhone" id="numberPhone" placeholder="06xxxxxx96" value="<?php echo "0" . $numberPhone; ?>" />

            <label for="fullname">Address :</label>
            <span><?php echo $addressError; ?></span>
            <input type="text" name="address" id="address" placeholder="123 Main Street, Anytown XXXX" value="<?php echo $address; ?>" />


            <label for="fullname">City :</label>
            <span><?php echo $cityError; ?></span>
            <input type="text" name="city" id="city" placeholder="Name City" value="<?php echo $city; ?>" />

            <label for="position">Position :</label>
            <span><?php echo $positionError; ?></span>
            <input type="text" name="position" id="position" placeholder="Full Time - Part Time" value="<?php echo $position; ?>" />

            <label for="workDay">Work Day :</label>


            <span><?php echo $workDayError; ?></span>


            <input type="text" name="workDays" placeholder="Monday..." value="<?php echo $workDays; ?>" />

            <label>Status :</label>
            <select name="status" class="status">
                <option value="in progress" <?php if ($status == 'in progress') echo 'selected="selected"'; ?>>In Progress</option>
                <option value="accept" <?php if ($status == 'accept') echo 'selected="selected"'; ?>>Accept</option>
            </select>

            <button type="submit" name="submit"><i class="fa-solid fa-pen-to-square"></i> &nbsp Edit User </button>
        </form>
    </div>
</body>

</html>