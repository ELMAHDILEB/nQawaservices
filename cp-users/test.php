<?php
require('../db/conn.php');
session_start();

// Check if the session variable is set
if (!isset($_SESSION['idUser'])) {
    header('Location: ./login.php');
    exit();
} else {
    $errorService = $errorAddress = $errorPhone = $errorDate = $errorHour = '';
    $insertSQL = true;

    if (isset($_GET['id'])) {
        $id_booking = mysqli_real_escape_string($conn, $_GET['id']);

        $query = "SELECT * FROM booking WHERE id_booking = '$id_booking'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $service = $row['service'];
            $numberPhone = $row['numberPhone'];
            $address = $row['address'];
            $date = $row['date'];
            $time = $row['time'];
        } else {
            echo "Booking ID is not provided.";
            exit();
        }
    } else {
        echo "<script>alert('DATA NO CHANGING')</script>";
        die();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST["submit"])) {
        $id_booking = mysqli_real_escape_string($conn, $_GET['id']);
        $allowService = ['House Cleaning', 'Commercial Cleaning', 'Green Clean'];
        $service = htmlentities(mysqli_real_escape_string($conn, stripslashes(isset($_POST['service']) ? $_POST['service'] : '')));
        $numberPhone = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['numberPhone']))));
        $address = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['address']))));
        $date = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['date'])));
        $time = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['time'])));

        // filter service
        if (!in_array($service, $allowService)) {
            $errorService = "<p style='color:#dc3545;'>Please Select Service</p>";
            $insertSQL = false;
        }
        // filter Phone Number
        if (empty($numberPhone)) {
            $errorPhone = "<p style='color:#dc3545;'>Number Phone is required</p>";
            $insertSQL = false;
        }
        // check is number or non and less or great than 10
        elseif (!ctype_digit($numberPhone) || strlen($numberPhone) != 10) {
            $errorPhone = "<p style='color:#dc3545;'>Please insert a valid 10-digit number</p>";
            $insertSQL = false;
        }
        // check input address is empty 
        if (empty($address) && !is_string($address)) {
            $errorAddress = "<p style='color:#dc3545;'>Address is required</p>";
            $insertSQL = false;
        } elseif (!preg_match('/^[a-zA-Z0-9 ]+$/', $address)) {
            $errorAddress = "<p style='color:#dc3545;'>Address should only contain alphanumeric characters</p>";
            $insertSQL = false;
        }
        // Validate Date Is empty 
        if (empty($date)) {
            $errorDate = "<p style='color:#dc3545;'>Please Choose Date</p>";
            $insertSQL = false;
        } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
            $errorDate = "<p style='color:#dc3545;'>Invalid Date</p>";
            $insertSQL = false;
        }
        // Validate Time
        if (empty($time)) {
            $errorHour = "<p style='color:#dc3545;'>Please Choose Time</p>";
            $insertSQL = false;
        } elseif ($time < '09:00:00' || $time > '18:00:00') {
            $errorHour = "<p style='color:#dc3545;'>Please Choose Time Between 09am and 6pm</p>";
            $insertSQL = false;
        }

        // check query and insertion to database
        if ($insertSQL) {
            $sql = "UPDATE booking SET `service` = '$service', `numberPhone` = '$numberPhone', `address` = '$address', `date` = '$date', `time` = '$time' WHERE `id_booking` = '$id_booking'";
            $rsl = mysqli_query($conn, $sql);
            if (!$rsl) {
                die("Query failed: " . mysqli_error($conn));
            } else {
                echo "<script>alert('Data Updated Successfully');</script>";
                header("Location: booking.php");
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        :root {
            --color-first: #2ebbd4;
            --color-second: #e7e7e7;
        }

        body {
            background-color: var(--color-second);
        }

        .layout {
            width: 100%;
            max-height: 1200px;
            padding: 2%;
            text-align: center;

            h1 {
                font-weight: 700;
            }

            form {
                width: 100%;
                height: 80vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                gap: 10px;

                label {
                    font-size: 16px;
                }

                select {
                    border: none;
                    outline: none;
                    padding: 1%;
                    font-weight: 700;
                }

                input {
                    width: 300px;
                    height: 30px;
                    outline: none;
                    border: none;
                    border-radius: 5px;
                    padding: 5px;
                    margin-bottom: 10px;
                }

                button {
                    padding: 10px 14px;
                    border-radius: 22px;
                    color: white;
                    text-decoration: none;
                    font-weight: 700;
                    background-color: var(--color-first);
                    cursor: pointer;
                    border: none;
                    outline: none;
                }
            }
        }
    </style>
    <title>Edit Booking</title>
</head>

<body>
    <div class="layout">
        <h1>Edit Booking</h1>
        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $row['id_booking']; ?>' method="post">
            <input type='hidden' name='id_booking' value='<?php echo $row['id_booking']; ?>'>
            <label>Service:</label>
            <span><?php echo $errorService; ?></span>
            <select name="service">
                <option value="House Cleaning" <?php if ($service == 'House Cleaning') echo 'selected="selected"'; ?>>House Cleaning</option>
                <option value="Commercial Cleaning" <?php if ($service == 'Commercial Cleaning') echo 'selected="selected"'; ?>>Commercial Cleaning</option>
                <option value="Green Clean" <?php if ($service == 'Green Clean') echo 'selected="selected"'; ?>>Green Clean</option>
            </select>
            <label>Phone Number:</label>
            <span><?php echo $errorPhone; ?></span>
            <input type="text" name="numberPhone" placeholder="Phone Number" value="<?php echo $numberPhone; ?>">
            <label>Address:</label>
            <span><?php echo $errorAddress; ?></span>
            <input type="text" name="address" placeholder="Add Your Address" value="<?php echo $address; ?>">
            <label>Date:</label>
            <span><?php echo $errorDate; ?></span>
            <input type="date" name="date" value="<?php echo $date; ?>">
            <label>Hours:</label>
            <span><?php echo $errorHour; ?></span>
            <input type="time" name="time" value="<?php echo $time; ?>">
            <button type="submit" value="submit" name="submit">Submit</button>
        </form>
    </div>
</body>

</html>
