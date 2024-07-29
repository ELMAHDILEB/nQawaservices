<?php
require_once('../db/conn.php');
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: login.php');
} else {


    $idUser = $_SESSION['idUser'];
    $errorService = $errorTypeOfService = $errorPhone = $errorAddress = $errorDate = $errorHour = '';
    $insertSQL = true;


    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST["submit"])) {

            $id_booking = $_POST['id_booking'];
            $allowService = ['House Cleaning', 'Commercial Cleaning', 'Green Clean'];
            $allowTypeOfService = ['Yes', 'No'];
            $service = htmlentities(mysqli_real_escape_string($conn, stripslashes(isset($_POST['service']) ? $_POST['service'] : '')));
            $typeOfService = htmlentities(mysqli_real_escape_string($conn, stripslashes(isset($_POST['typeOfService']) ? $_POST['typeOfService'] : '')));
            $numberPhone = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['numberPhone']))));
            $address = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['address']))));
            $date = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['date'])));
            $time = htmlentities(mysqli_real_escape_string($conn, stripslashes($_POST['time'])));
             
            

            // filter service
            if (!in_array($service, $allowService)) {
                $errorService = "<p class='msg' style='color:#dc3545;'>Please Select Service</p>";
                $insertSQL = false;
            }
            // filter Type Of service
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


            // check query and insertion to database

            if ($insertSQL) {
                $query = "INSERT INTO booking(idUser, id_booking, service, typeOfService, numberPhone, address, date, time) VALUES('$idUser', '$id_booking', '$service','$typeOfService', '$numberPhone', '$address', '$date', '$time')";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    echo "<script>alert('DATA INSERT')</script>";
                    header("Location: booking.php");
                }

            } else {
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
        <title>Add Booking</title>
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");
             ::root{
                --color-black: rgb(0,0,0,);
             }
            * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
                font-family: "poppins", sans-serif;
            }
            body{
                width: 100%;
                height: 100vh;
                background-color: #e7e7e7;
            }
            .layout {
                width: 100%;
                height: 100%;
                padding: 2%;
                display: flex;
                flex-direction: column;
                align-items: center;
                background-color: #e7e7e7;
                gap: 40px;
            }

            .layout h1 {
                font-size: clamp(16px,3vw,22px);
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
                cursor: pointer;
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
                font-weight: 700;
                background-color: #2ebbd4;
                cursor: pointer;
                border: none;
                outline: none;
            }
            .msg{
                font-size: 14px;
                font-weight: 500;
                color: red;
            }
            
        </style>

    </head>

    <body>
        <div class="layout">

            <h1>Fill out the form so we can reach you</h1>
            <p>Office hours are 09am to 18pm</p>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="id_booking" value="<?php echo $id_booking; ?>">


                <label>Service:</label>
                <span><?php echo $errorService; ?></span>
                <select name="service">
                    <option value="" disabled selected>Choose Your Service</option>
                    <option value="House Cleaning" <?php if (isset($_POST['service']) && $_POST['service'] == 'House Cleaning') echo 'selected="selected"'; ?>>House Cleaning</option>
                    <option value="Commercial Cleaning" <?php if (isset($_POST['service']) && $_POST['service'] == 'Commercial Cleaning') echo 'selected="selected"'; ?>>Commercial Cleaning</option>
                    <option value="Green Clean" <?php if (isset($_POST['service']) && $_POST['service'] == 'Green Clean') echo 'selected="selected"'; ?>>Green Clean</option>
                </select>
                
                <label>Type Of Service:</label>
                <span><?php echo $errorTypeOfService; ?></span>
                <select name="typeOfService">
                    <option value="" disabled selected>Select Type Of Service</option>
                    <option value="Yes" <?php if (isset($_POST['typeOfService']) && $_POST['typeOfService'] == 'Yes') echo 'selected="selected"'?>>With Machine Robots</option>
                    <option value="No" <?php if (isset($_POST['typeOfService']) && $_POST['typeOfService'] == 'No') echo 'selected="selected"'?>>Without Machine Robots</option>
                    
                </select>

                <label>Phone Number:</label>
                <span><?php echo $errorPhone; ?></span>
                <input type="text" name="numberPhone" placeholder="Phone Number" value="<?php if (isset($_POST['numberPhone'])) echo $_POST['numberPhone']; ?>">
                <label>Address:</label>
                <span><?php echo $errorAddress; ?></span>
                <input type="text" name="address" placeholder="Add Your Address" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>">
                <label>Date:</label>
                <span><?php echo $errorDate; ?></span>
                <input type="date" name="date" value="<?php if (isset($_POST['date'])) echo $_POST['date']; ?>">
                <label>Hours:</label>
                <span><?php echo $errorHour; ?></span>
                <input type="time" name="time" value="<?php if (isset($_POST['time'])) echo $_POST['time']; ?>">

                <button type="submit" value="submit" name="submit">Submit</button>
            </form>
        </div>
    </body>

    </html>
<?php } ?>