<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    
    header("Location: ../cp-team/login.php");
    exit();
}else{
    
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FILE CSS -->
    <link rel="stylesheet" href="./style.css">
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin Panel</title>
</head>

<body>
    <header>
        <div class="openSideBar" aria-pressed="false" onclick="showSidebar()"><i class="fa-solid fa-bars"></i></div>
        <div class="right">
            <a href="index.php?page=logout" name="logout">logout</a>
            <div class="icon" >
                    <i class="fa-solid fa-sun" id="icon"></i>
                </div>
        </div>
    </header>
    
    <aside class="sidebar">
        <div class="closeSideBar" aria-pressed="false" onclick="hideSidebar()"><i class="fa-solid fa-xmark"></i></div>
        <h1>Admin Panel</h1>
        <nav>
            <ul>
                <li><a href="index.php?page=dashboard"><i class="fa-solid fa-gauge-simple-high"></i>&nbsp; Dashboard</a></li>
                <li class="dropdown">
                    <a href="index.php?page=team" ><i class="fa-solid fa-users"></i>&nbsp; Team and Customer</a>
                    <button class="dropBtn"><i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="index.php?page=add__user">Add User</a>
                        <a href="index.php?page=customer">Customer</a>
                        <a href="index.php?page=add__customer">Add Customer</a>
                        <a href="index.php?page=opinions">Opinions</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="index.php?page=booking"><i class="fa-regular fa-calendar-days"></i>&nbsp; Booking</a>
                    <button class="dropBtn"><i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="index.php?page=add__booking">Add Booking</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="index.php?page=products" ><i class="fa-solid fa-cart-shopping"></i>&nbsp; Products </a>
                    <button class="dropBtn"><i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="index.php?page=add__product">Add Product</a>
                        <a href="index.php?page=edit__product">Edit Product</a>
                    </div>
                </li>
                <li class="dropdown">
                <a href="index.php?page=blog"><i class="fa-solid fa-square-rss"></i>&nbsp; Blog</a>
                    <button class="dropBtn"><i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <a href="index.php?page=add__blog">Add Blog</a>
                    </div>
                </li>
                <li><a href="index.php?page=messages"><i class="fa-solid fa-envelope"></i>&nbsp; Messages</a></li>
            </ul>
        </nav>
    </aside>

    <main>
        <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
                switch ($page) {
                    case 'dashboard':
                        include 'dashboard.php';
                        break;
                    case 'search':
                        include 'searchBox.php';
                        break;
                    case 'team':
                        include 'team.php';
                        break;
                    case 'add__user':
                        include 'add__user.php';
                        break;
                    case 'edit__user':
                        include 'edit__user.php';
                        break;
                    case 'customer':
                        include 'customer.php';
                        break;
                    case 'opinions':
                        include 'opinions.php';
                        break;
                    case 'edit__opinion':
                        include 'edit__opinion.php';
                        break;
                    case 'delete__opinions':
                        include 'delete__opinion.php';
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
                    case 'products':
                        include 'products.php';
                        break;
                    case 'add__product':
                        include 'add__product.php';
                        break;
                    case 'edit__product':
                        include 'edit__product.php';
                        break;
                    case 'blog':
                        include 'blog.php';
                        break;
                    case 'add__blog':
                        include 'add__blog.php';
                        break;
                    case 'edit__blog':
                        include 'edit__blog.php';
                        break;
                    case 'messages':
                        include 'messages.php';
                        break;
                    case 'logout':
                        include 'logout.php';
                        break;
                    default:
                        include 'dashboard.php';
                }
                ?>
    </main>
    <script src="../JS/index.js"></script>
   

</body>

</html>