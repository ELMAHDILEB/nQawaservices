<?php
session_start(); // Start session if not already started
require_once("./db/conn.php");

$errorUsername = $errorFullname = $errorEmail = $errorPassword = $errorNumberPhone = $errorAddress = $errorCity = $errorPosition = $errorWorkDays = '';
$insertSQL = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $username = isset($_POST['username']) ? htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['username'])))) : '';
    $fullname = isset($_POST['fullname']) ? htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['fullname'])))) : '';
    $email = isset($_POST['email']) ? htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['email'])))) : '';
    $password = isset($_POST['password']) ? htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['password'])))) : '';
    $numberPhone = isset($_POST['numberPhone']) ? htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['numberPhone'])))) : '';
    $address = isset($_POST['address']) ? htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['address'])))) : '';
    $city = isset($_POST['city']) ? htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['city'])))) : '';
    $positionArray = isset($_POST['position']) ? $_POST['position'] : array();
    $workDaysArray = isset($_POST['workDays']) ? $_POST['workDays'] : array();

    if (!empty($username) && !empty($fullname) && !empty($email) && !empty($password) && !empty($numberPhone) && !empty($address) && !empty($city) && !empty($positionArray) && !empty($workDaysArray))  {
    
        // Validate username
        $selectUsername = "SELECT username FROM workers WHERE username = '$username' 
                           UNION 
                           SELECT username FROM register WHERE username = '$username'";
        $resUser = mysqli_query($conn, $selectUsername);
        if (mysqli_num_rows($resUser) > 0 || strlen($username) < 8) {
            $errorUsername = "<p class='msgError'>Username already exists or is less than 8 characters</p>";
            $insertSQL = false;
        }

        // Validate fullname
        if (!preg_match('/^[a-zA-Z ]+$/', $fullname)) {
            $errorFullname = "<p class='msgError'>Full name should only contain alpha characters</p>";
            $insertSQL = false;
        }

        // Validate email
        $selectEmail = "SELECT email FROM workers WHERE email = '$email' 
                        UNION 
                        SELECT email FROM register WHERE email = '$email'";
        $resEmail = mysqli_query($conn, $selectEmail);
        if (mysqli_num_rows($resEmail) > 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorEmail = "<p class='msgError'>Email already exists or is invalid</p>";
            $insertSQL = false;
        }

        // Validate numberPhone
        if (!ctype_digit($numberPhone)) {
            $errorNumberPhone = "<p class='msgError'>Please write correct number phone</p>";
            $insertSQL = false;
        }

        // Validate address
        if (!preg_match('/^[a-zA-Z0-9 ]+$/', $address)) {
            $errorAddress = "<p class='msgError'>Address should only contain alphanumeric characters</p>";
            $insertSQL = false;
        }

        // Validate city
        if (!preg_match('/^[a-zA-Z ]+$/', $city)) {
            $errorCity = "<p class='msgError'>City should only contain alpha characters</p>";
            $insertSQL = false;
        }

        // Validate position
        foreach ($positionArray as $posi) {
            $posi = strtolower($posi);
            if (!in_array($posi, ['full time', 'part time'])) {
                $errorPosition = "<p class='msgError'>Please select valid position</p>";
                $insertSQL = false;
                break;
            }
        }

        // Validate workDays
        foreach ($workDaysArray as $day) {
            $day = strtolower($day);
            if (!in_array($day, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])) {
                $errorWorkDays = "<p class='msgError'>Please select valid work days</p>";
                $insertSQL = false;
                break;
            }
        }

        if ($insertSQL) {
            // Hash password before storing
            $hashedPassword = hash('sha256', $password);

            // Convert arrays to comma-separated strings
            $position = implode(',', $positionArray);
            $workDays = implode(', ', $workDaysArray);

            // Insert data into database
            $query = "INSERT INTO workers (type, username, fullname, email, password, numberPhone, address, city, position, workDays) 
                      VALUES ('', '$username', '$fullname', '$email', '$hashedPassword', '$numberPhone', '$address', '$city', '$position', '$workDays')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "<script>alert('Please wait for membership acceptance, then a message will be sent to your email');</script>";
            } else {
                echo "<script>alert('Failed to insert into database');</script>";
            }
        } else {
            echo "<script>alert('Please do not forget to fill in all fields');</script>";
        }
    } 
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META START -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Immerse yourself in the ultimate combination of cleanliness and comfort with GoodHome. Our dedicated team delivers exceptional cleaning services, transforming your space into a spotless haven of tranquility. Experience the joy of a pristine and inviting living environment with us.">
    <meta name="keywords" content="cleaning house job, cleaning house services, cleaning commercial services, cleaning services job, cleaning green spaces">
    <meta name="author" content="EL MAHDI BELCADI">
    <meta name="theme-color" content="#4285f4" />
    <!-- META END -->
    <link rel="stylesheet" href="./cp-team/style.css">
    <!-- GOOGLE FONT FILE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Job Application</title>
</head>

<body>

    <!-- EMPLOYMENT START -->
    <section id="employment">





        <form action="" method="post" class="form__job">
            <h2>Job Offer</h2>

            <label for="username">Enter Your Username:</label>
            <span><?php echo $errorUsername; ?></span>
            <input type="text" placeholder="Username" id="username" name="username"  />

            <label for="name">Enter Your Full Name:</label>
            <span><?php echo $errorFullname; ?></span>
            <input type="text" placeholder="Full Name" id="name" name="fullname"  />

            <label for="mail">Enter Your Email Address:</label>
            <span><?php echo $errorEmail; ?></span>
            <input type="email" placeholder="Email Address" id="mail" name="email"  />

            <label for="password">Enter Your Password:</label>
            <span><?php echo $errorPassword; ?></span>
            <input type="password" placeholder="Password" id="password" name="password"  />

            <label for="phone">Enter Your Number Phone:</label>
            <span><?php echo $errorNumberPhone; ?></span>
            <input type="number" placeholder="Number Phone" id="phone" name="numberPhone"  />

            <label for="address">Enter Your Address:</label>
            <span><?php echo $errorAddress; ?></span>
            <input type="text" placeholder="Address" id="address" name="address"  />

            <label for="city">Enter Your City:</label>
            <span><?php echo $errorCity; ?></span>
            <input type="text" placeholder="City" id="city" name="city"  />

            <label>Employment Position :</label>
            <span><?php echo $errorPosition; ?></span>
            <div class="position">
                <div class="input__style">
                    <input type="radio" name="position[]" value="full time" id="fulltime" />
                    <label for="fulltime">Full Time</label>
                </div>
                <div class="input__style">
                    <input type="radio" name="position[]" value="part time" id="parttime" />
                    <label for="parttime">Part Time</label>
                </div>


            </div>
            <label>What days are you willing to work? :</label>
            <span><?php echo $errorWorkDays; ?></span>
            <div class="position">
                <div class="input__style">
                    <input type="checkbox" name="workDays[]" value="monday" id="monday" />
                    <label for="monday">Monday</label>
                </div>
                <div class="input__style">
                    <input type="checkbox" name="workDays[]" value="tuesday" id="tuesday" />
                    <label for="tuesday">Tuesday</label>
                </div>
                <div class="input__style">
                    <input type="checkbox" name="workDays[]" value="wednesday" id="wednesday" />
                    <label for="wednesday">Wednesday</label>
                </div>
                <div class="input__style">
                    <input type="checkbox" name="workDays[]" value="thursday" id="thursday" />
                    <label for="thursday">Thursday</label>
                </div>
                <div class="input__style">
                    <input type="checkbox" name="workDays[]" value="friday" id="friday" />
                    <label for="friday">Friday</label>
                </div>
                <div class="input__style">
                    <input type="checkbox" name="workDays[]" value="saturday" id="saturday" />
                    <label for="saturday">Saturday</label>
                </div>
                <div class="input__style">
                    <input type="checkbox" name="workDays[]" value="sunday" id="sunday" />
                    <label for="sunday">Sunday</label>
                </div>






            </div>
            <button type="submit" name="submit">send</button>


        </form>




    </section>
    <!-- EMPLOYMENT END -->

</body>

</html>