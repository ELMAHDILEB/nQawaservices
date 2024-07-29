
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile USER</title>
    <!-- GOOGLE FONT FILE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");

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

        /* HEADER START */
        header {
            width: 100%;
            height: 100px;
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: var(--color-first);
        }

        .top__nav {
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 80%;
            height: 40px;
            margin: 0 auto;
        }

        .horaire {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .horaire :where(i, p) {
            font-size: 16px;
            color: var(--color-black);
        }

        .icon__social {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon__social :where(a, i) {
            font-size: 16px;
            transition: 1s ease;
            color: var(--color-black);
        }

        .icon__social a i:hover {
            scale: 1.2;
        }

        .bottom__nav {
            width: 100%;
            height: 60px;
            background-color: var(--color-second);
            color: var(--color-black);
        }

        .container {
            width: 80%;
            height: 60px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .container nav ul li {
            list-style: none;
            display: inline-block;
            margin-left: 10px;
        }

        .logo h1 {
            color: var(--color-black);
            text-transform: uppercase;
            font-size: 1.5em;
        }

        .logo span {
            color: #2c707b;
        }

        .mobile {
            display: none;
        }

        .container nav ul li a {
            text-decoration: none;
            font-size: 16px;
            font-weight: 400;
            text-transform: capitalize;
            color: currentColor;
        }

        .icon,
        .openMenu {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            background-color: var(--color-box);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            cursor: pointer;
        }

        .icon img {
            width: 60%;
            object-fit: cover;
            cursor: pointer;
            filter: var(--filter);
            transition: 1s ease-in-out;
        }


        .openMenu,
        .closeMenu {
            font-size: 1.5em;
            color: var(--color-black);
            cursor: pointer;
            display: none;
        }

        @media (max-width:832px) {
            .logo h1 {
                font-size: 1.2em;
            }

            .container nav ul li a {
                font-size: 14px;
            }
        }

        @media (max-width:768px) {
            .list {
                display: none;
            }

            .mobile {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 20px;
                width: 100%;
                height: 100vh;
                position: absolute;
                inset: 0;
                background-color: var(--color-mobile);
                padding: 10%;
                transform: translateX(-1000%);
                transition: 0.5s ease-in-out;
            }

            .container nav ul li a {
                color: var(--color-text);
                font-size: 1em;
                font-weight: 800;
            }

            .openMenu {
                display: block;
            }

            .closeMenu {
                display: block;
                color: var(--color-text);
                position: relative;
                z-index: 10000;
            }
        }

        @media (max-width: 500px) {

            .top__nav {
                width: 100%;
                padding: 0px 22px;
                height: 65px;
            }

            .container {
                width: 100%;
                padding: 0 3%;
            }
        }

        @media (max-width:445px) {
            .top__nav {
                flex-direction: column;
            }

            .horaire :where(i, p) {
                font-size: 13px;
                color: var(--color-black);
            }

            .logo h1 {
                font-size: 1.1em;
            }

            .container nav ul li a {
                color: var(--color-text);
                font-size: 0.8em;
                font-weight: 800;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="top__nav">

            <div class="horaire">
                <i class="fa-solid fa-clock" style="font-size: 13px;"></i>
                <p>Monday – Friday: 09h00 – 18h00</p>

            </div>
            <div class="icon__social">
                <a href="#" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" target="_blank" rel="noopener"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="bottom__nav">

            <div class="container">
                <div class="logo">
                    <h1><span>nQawa</span> Services</h1>
                </div>

                <nav>
                    <ul class="mobile">
                        <div class="closeMenu" aria-pressed="false" onclick="hide()"><i class="fa-solid fa-xmark"></i></div>
                        <li><a href="edit-account.php">Edit Account</a></li>
                        <li><a href="booking.php">Booking</a></li>
                        <li><a href="testimonial.php">Add You Opinion</a></li>
                        <li><a href="logout.php">Log Out</a></li>


                    </ul>
                    <ul class="list">
                        <li><a href="edit-account.php">Edit Account</a></li>
                        <li><a href="booking.php">Booking</a></li>
                        <li><a href="testimonial.php">Add You Opinion</a></li>
                        <li><a href="logout.php">Log Out</a></li>

                    </ul>
                </nav>
               
                <div class="icon" >
                    <i class="fa-solid fa-sun" id="icon"></i>
                </div>

                <div class="openMenu" aria-pressed="false" onclick="show()"><i class="fa-solid fa-bars"></i></div>
            </div>

    </header>

    <script src="../JS/index.js" defer>
    </script>
    
</body>

</html>