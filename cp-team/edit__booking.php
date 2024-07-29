<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'worker') {

    header("Location: ../cp-team/login.php");
    exit();
} else {
    $errorService = $errorTypeOfService  = $errorPhone = $errorAddress = $errorDate =  $errorHour = '';
    $insertSQL = true;

    if (isset($_GET['id'])) {
        $id_booking = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT * FROM booking WHERE id_booking = '$id_booking'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id_booking = $row['id_booking'];
            $service = $row['service'];
            $typeOfService = $row['typeOfService'];
            $numberPhone = $row['numberPhone'];
            $address = $row['address'];
            $date = $row['date'];
            $time = $row['time'];
            $status = $row['status'];
        } else {
            echo "<script>alert('Booking ID is not provided.')</script>";
            sleep(3);
            header("Location: index.php?page=booking");
            exit();
        }
    } else {
        header("Location: index.php?page=booking");
        die();
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["submit"])) {


        $allowService = ['House Cleaning', 'Commercial Cleaning', 'Green Clean'];
        $allowTypeOfService = ['Yes', 'No'];
        $service = htmlentities(mysqli_real_escape_string($conn, stripslashes(isset($_POST['service']) ? $_POST['service'] : '')));
        $typeOfService = htmlentities(mysqli_real_escape_string($conn, stripslashes(isset($_POST['typeOfService']) ? $_POST['typeOfService'] : '')));
        $numberPhone = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['numberPhone']))));
        $address = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['address']))));
        $date = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['date'])));
        $time = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['time'])));
        $status = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['status'])));

        // filter service
        if (!in_array($service, $allowService)) {
            $errorService = "<p class='msg' style='color:#dc3545;'>Please Select Service</p>";
            $insertSQL = false;
        }
        // filter type of service
        if (!in_array($typeOfService, $allowTypeOfService)) {
            $errorTypeOfService = "<p class='msg' style='color:#dc3545;'>Please Select Type Of Service</p>";
            $insertSQL = false;
        }
        // filter Phone Number
        if (empty($numberPhone)) {
            $errorPhone = "<p class='msg' style='color:#dc3545;'>Number Phone is required</p>";
            $insertSQL = false;
        }
        // check is number or non and less or great than 10
        elseif (!ctype_digit($numberPhone) || strlen($numberPhone) != 10) {
            $errorPhone = "<p class='msg' style='color:#dc3545;'>Please insert a valid 10-digit number</p>";
            $insertSQL = false;
        }
        // check input address is empty 
        if (empty($address) && !is_string($address)) {
            $errorAddress = "<p class='msg' style='color:#dc3545;'>Address is required</p>";
            $insertSQL = false;
        } elseif (!preg_match('/^[a-zA-Z0-9 ]+$/', $address)) {
            $errorAddress = "<p class='msg' style='color:#dc3545;'>Address should only contain alphanumeric characters</p>";
            $insertSQL = false;
        }
        // Validate Date Is empty 
        if (empty($date)) {
            $errorDate = "<p  class='msg' style='color:#dc3545;'>Please Choose Date</p>";
            $insertSQL = false;
        } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
            $errorDate = "<p class='msg' style='color:#dc3545;'>Invalid Date</p>";
            $insertSQL = false;
        }
        // Validate Time
        if (empty($time)) {
            $errorHour = "<p style='color:#dc3545;'>Please Choose Time</p>";
            $insertSQL = false;
        } elseif ($time < '09:00:00' || $time > '18:00:00') {
            $errorHour = "<p class='msg' style='color:#dc3545;'>Please Choose Time Between 09am and 6pm</p>";
            $insertSQL = false;
        }

        if ($insertSQL) {


            $sql = "UPDATE booking SET service = '$service', typeOfService = '$typeOfService',numberPhone = '$numberPhone', address = '$address', date = '$date', time = '$time',status = '$status' WHERE `id_booking` = '$id_booking'";
            $rsl = mysqli_query($conn, $sql);


            if ($rsl) {
                echo "<script>alert('Data Update Successfully');</script>";
                echo "<script>window.location = 'index.php?page=booking';</script>";
            } else {
                echo "<script>alert('Failed to insert data');</script>";
            }
        }
    } else {

        echo "<script>window.location = 'edit__booking.php?id=" . $row['id_booking'] . ";</script>";
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
    <title>Edit Booking</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");

        :root {
            --color-black: rgb(0, 0, 0, );
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "poppins", sans-serif;
        }

        body {
            width: 100%;
            background-color: #e7e7e7;
        }

        .layout {
            width: 100%;
            padding: 2%;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #e7e7e7;
            gap: 40px;
        }

        .layout h1 {
            font-size: clamp(18px, 5vw, 25px);
            text-transform: capitalize;
        }

        .layout form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .layout form label {
            font-size: 16px;
        }

        .layout form select {
            background: white;
            border: none;
            outline: none;
            padding: 2%;
            font-weight: 700;
        }

        .layout form input {
            width: 300px;
            height: 30px;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
        }

        .layout form button {
            padding: 10px 14px;
            border-radius: 22px;
            color: var(--color-black);
            text-decoration: none;
            font-size: clamp(11px, 3vw, 16px);
            font-weight: 400;
            background-color: #2ebbd4;
            cursor: pointer;
            border: none;
            outline: none;
        }

        .msg {
            font-size: 14px;
            font-weight: 500;
        }
    </style>

</head>

<body>
    <div class="layout">

        <h1>Edit Booking</h1>


        <form action="" method="post">



            <label>Service:</label>
            <span><?php echo $errorService; ?></span>
            <select name="service">
                <option value="House Cleaning" <?php if ($service == 'House Cleaning') echo 'selected="selected"'; ?>>House Cleaning</option>
                <option value="Commercial Cleaning" <?php if ($service == 'Commercial Cleaning') echo 'selected="selected"'; ?>>Commercial Cleaning</option>
                <option value="Green Clean" <?php if ($service == 'Green Clean') echo 'selected="selected"'; ?>>Green Clean</option>
            </select>

            <label>Type Of Service:</label>
                <span><?php echo $errorTypeOfService; ?></span>
                <select name="typeOfService">
                    <option value="" disabled selected>Select Type Of Service</option>
                    <option value="Yes" <?php if ($typeOfService == 'yes') echo 'selected="selected"'; ?>>With Machine Robots</option>
                    <option value="No" <?php if ($typeOfService == 'no') echo 'selected="selected"'; ?>>Without Machine Robots</option>
                    
                </select>

            <label>Phone Number:</label>
            <span><?php echo $errorPhone; ?></span>
            <input type="text" name="numberPhone" placeholder="Phone Number" value="<?php echo "0" .$numberPhone; ?>">
            <label>Address:</label>
            <span><?php echo $errorAddress; ?></span>
            <input type="text" name="address" placeholder="Add Your Address" value="<?php echo $address; ?>">
            <label>Date:</label>
            <span><?php echo $errorDate; ?></span>
            <input type="date" name="date" value="<?php echo $date ?>">
            <label>Hours:</label>
            <span><?php echo $errorHour; ?></span>
            <input type="time" name="time" value="<?php echo $time; ?>">

            <label>Status :</label>
            <select name="status" class="status">
                <option value="in progress" <?php if ($status == 'in progress') echo 'selected="selected"'; ?>>In Progress</option>
                <option value="accept" <?php if ($status == 'accept') echo 'selected="selected"'; ?>>Accept</option>
            </select>

            <button type="submit" value="submit" name="submit"><i class="fa-solid fa-pen-to-square"></i> &nbsp Edit Booking</button>
        </form>
    </div>
</body>

</html>