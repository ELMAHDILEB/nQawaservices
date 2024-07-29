<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'worker') {

    header("Location: ../cp-team/login.php");
    exit();
} else {
   
     $queryBooking = "SELECT * FROM booking";
     $runBooking = mysqli_query($conn, $queryBooking);
     $rowsBookings = mysqli_fetch_assoc($runBooking);
     $queryRegister  = "SELECT * FROM register";
     $runRegister = mysqli_query($conn, $queryRegister);
     $rowsRegisters = mysqli_fetch_assoc($runRegister);
     foreach($rowsBookings as $rowsBooking){
          
     } 

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FILE CSS -->
    <link rel="stylesheet" href="../cp-admin/style.css">
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Team Panel</title>
</head>

<body>
    <header>
        <div class="openSideBar" aria-pressed="false" onclick="showSidebar()"><i class="fa-solid fa-bars"></i></div>
        <div class="right">
            <a href="index.php?page=logout" name="logout">logout</a>
            <div class="icon">
                <i class="fa-solid fa-sun" id="icon"></i>
            </div>
        </div>
    </header>

    <aside class="sidebar">
        <div class="closeSideBar" aria-pressed="false" onclick="hideSidebar()"><i class="fa-solid fa-xmark"></i></div>
        <h1>Panel Team</h1>
        <nav>
            <ul>
                <li><a href="index.php?page=panel-team"><i class="fa-solid fa-gauge-simple-high"></i>&nbsp; Panel Team</a></li>
                <li class="dropdown">
                    <a href="index.php?page=customer"><i class="fa-solid fa-users"></i>&nbsp; Customer</a>
                    <button class="dropBtn"><i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="index.php?page=add__customer">Add Customer</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="index.php?page=booking"><i class="fa-regular fa-calendar-days"></i>&nbsp; Booking</a>
                    <button class="dropBtn"><i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="index.php?page=add__booking">Add Booking</a>
                    </div>
                </li>
                
                
               
            </ul>
        </nav>
    </aside>

    <main>
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'panel-team';
        switch ($page) {
            case 'panel-team':
                include 'panel-team.php';
                break;
            case 'customer':
                include 'customer.php';
                break;
            case 'add__customer':
                include 'add__customer.php';
                break;
            case 'edit__customer':
                include 'edit__customer.php';
                break;
            case 'booking':
                include 'booking.php';
                break;
            case 'add__booking':
                include 'add__booking.php';
                break;
            case 'edit__booking':
                include 'edit__booking.php';
                break;
            
            case 'logout':
                include 'logout.php';
                break;
            default:
                include 'panel-team.php';
        }
        ?>
    </main>
    <script src="../JS/index.js"></script>


</body>

</html>