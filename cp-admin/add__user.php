<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {

    $typeError = $userNameError = $fullNameError = $emailError = $numberPhoneError = $addressError = $cityError = $positionError = $workDayError = $passwordError = '';
    $insertSQL = true;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

        $allowType = ['admin','worker'];
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




        if (!empty($type) && !empty($username) && !empty($fullname) && !empty($email) && !empty($password) && !empty($numberPhone) && !empty($address) && !empty($city) && !empty($position) && !empty($workDays)) {

            // Validate A type  Input
            if (!in_array($type, $allowType)) {
                $typeError = "<p class='msgError'>Please select one type Admin - Leader - Worker!</p>";
                $insertSQL = false;
            }
   
            // Validate Input User Name Input
            
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
                $type = strtolower($type);
                
                $query = "INSERT INTO workers (type, username, fullname, email, password, numberPhone, address, city, position, workDays) VALUES ('$type', '$username', '$fullname', '$email', '" . hash('sha256', $password) . "', '$numberPhone', '$address', '$city', '$position', '$workDays')";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $_SESSION['idWorker'] = $row['idWorker'];
                    echo "<script>alert('Data Insert Successfully'); window.location = 'index.php?page=team';</script>";
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
            font-size: clamp(14px, 2vw, 18px);
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

        #workDay {
            background: none;
            border: none;
            outline: none;
            padding: 10px 14px;
            text-align: center;
            width: 200px;
            height: 200px;
            color: black;
            text-transform: capitalize;
            overflow: hidden;
        }

        #workDay option {
            margin-bottom: 7px;
            cursor: pointer;
        }

        #workDay option::selection {
            background: #2ebbd4;
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
        <h1>Add New User :</h1>
        <form action="" method="post">
            <label for="type">Select Type User :</label>
            <span><?php echo $typeError; ?></span>
            <input type="text" name="type" id="type" placeholder="Admin - Worker" value="<?php if (isset($type)) {
                                                                                                    echo $type;
                                                                                                } ?>">
            <!-- USER NAME -->
            <label for="username">Username :</label>
            <span><?php echo $userNameError; ?></span>
            <input type="text" name="username" id="username" placeholder="John Deo" value="<?php if (isset($username)) {
                                                                                                echo $username;
                                                                                            } ?>" />

            <label for="fullname">Full Name :</label>
            <span><?php echo $fullNameError; ?></span>
            <input type="text" name="fullname" id="fullname" placeholder="John Deo" value="<?php if (isset($fullname)) {
                                                                                                echo $fullname;
                                                                                            } ?>" />

            <label for="email">E-mail :</label>
            <span><?php echo $emailError; ?></span>
            <input type="email" name="email" id="email" placeholder="john.deo@mail.com" value="<?php if (isset($email)) {
                                                                                                    echo $email;
                                                                                                } ?>" />
            <label for="password">Password :</label>
            <span><?php echo $passwordError; ?></span>
            <input type="password" name="password" id="password" value="" />

            <label for="numberPhone">Number Phone :</label>
            <span><?php echo $numberPhoneError; ?></span>
            <input type="text" name="numberPhone" id="numberPhone" placeholder="06xxxxxx96" value="<?php if (isset($numberPhone)) {
                                                                                                        echo $numberPhone;
                                                                                                    } ?>" />

            <label for="address">Address :</label>
            <span><?php echo $addressError; ?></span>
            <input type="text" name="address" id="address" placeholder="123 Main Street, Anytown XXXX" value="<?php if (isset($address)) {
                                                                                                                    echo $address;
                                                                                                                } ?>" />


            <label for="city">City :</label>
            <span><?php echo $cityError; ?></span>
            <input type="text" name="city" id="city" placeholder="Name City" value="<?php if (isset($city)) {
                                                                                        echo $city;
                                                                                    } ?>" />

            <label for="position">Position :</label>
            <span><?php echo $positionError; ?></span>
            <input type="text" name="position" id="position" placeholder="Full Time - Part Time" value="<?php if (isset($position)) {
                                                                                                            echo $position;
                                                                                                        } ?>" />

            <label for="workDay">Work Day :</label>


            <span><?php echo $workDayError; ?></span>

            <!-- <select name="workDays" id="workDay" multiple>
                <option value="monday">monday</option>
                <option value="tuesday">tuesday</option>
                <option value="wednesday">wednesday</option>
                <option value="tuesday">thursday</option>
                <option value="thursday">friday</option>
                <option value="friday">saturday</option>
                <option value="monday">sunday</option>
            </select> -->
            <input type="text" name="workDays" placeholder="Monday..." value="<?php if (isset($workDays)) {
                                                                                    echo $workDays;
                                                                                } ?>" />

            <button type="submit" name="submit">+ &nbsp Add User</button>
        </form>
    </div>
</body>

</html>