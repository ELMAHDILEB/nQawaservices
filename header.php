<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- GSAP CDN -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script> -->
    <!-- GOOGLE FONT FILE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
            --color-logo: #4fc6db;
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

        html {
            scroll-behavior: smooth;
        }

        /* GENERAL STYLING  */
        .primary__title {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2%;
            margin-bottom: 25px;
        }

        .primary__title h1 {
            text-align: center;
            font-weight: unset;
            font-size: 34px;
            text-transform: capitalize;
            margin-bottom: 10px;
            color: var(--color-black);
        }

        .primary__title span {
            width: 140px;
            height: 5px;
            background-color: var(--color-first);
        }

        a {
            text-decoration: none;
        }

        /* GENERAL STYLING  */
        body {
            /* width:80%;
    margin: 0 auto; */
            /* background-color: var(--color-second); */
            overflow-x: hidden;
        }

        /* HEADER START */
        header {
            width: 100%;
            height: 100px;
            position: sticky;
            top: 0;
            left: 0;
            z-index: 10;
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
            width: 100%;
            height: 60px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10%;
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

        }

        .icon i {
            width: 60%;
            object-fit: cover;
            transition: 1s ease-in-out;
            /* filter: var(--filter); */
            cursor: pointer;
        }



        .openMenu,
        .closeMenu {
            font-size: 1.5em;
            color: var(--color-black);
            cursor: pointer;
            display: none;
        }
        @media (max-width: 768px) {
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
    left: 0;
    top: 0;
    background-color: var(--color-mobile);
    padding: 10%;
    transform: translateX(-1000%);
    transition: 0.5s ease-in-out;
  }

  .container nav ul li a {
    color: var(--color-text);
    font-size: 1.5em;
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
  .container{
    padding:0 2%;
  }
}
        /* HEADER END */
    </style>
</head>

<body>
    <header class="header" id="header">
        <div class="top__nav">

            <div class="horaire">
                <i class="fa-solid fa-clock" style="font-size: 13px;"></i>
                <p>Monday – Friday: 09h00 – 18h00</p>

            </div>
            <div class="icon__social">
                <a href="www.facebook.com/NQAWASERVICES/" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#www.twitter.com/NQAWASERVICES/" target="_blank" rel="noopener"><i class="fa-brands fa-x"></i></a>
                <a href="www.instagram.com/NQAWASERVICES/" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>
                <a href="www.linkedin.com/NQAWASERVICES/" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="bottom__nav">

            <div class="container">
                <div class="logo">
                   <a href="./"><h1><span>nQawa</span> Services</h1></a> 
                </div>


                <nav>
                    <ul class="mobile">
                        <div class="closeMenu" aria-pressed="false" onclick="hide()"><i class="fa-solid fa-xmark"></i>
                        </div>
                        <li><a href="../">home</a></li>
                        <li><a href="../#about">about</a></li>
                        <li><a href="../#services">services</a></li>
                        <li><a href="../#contact">contact</a></li>
                        <li><a href="./">blog</a></li>

                    </ul>
                    <ul class="list">
                        <li><a href="../">home</a></li>
                        <li><a href="../#about">about</a></li>
                        <li><a href="../#services">services</a></li>
                        <li><a href="../#contact">contact</a></li>
                        <li><a href="./">blog</a></li>

                    </ul>
                </nav>
                <!-- <a href="#" class="button" role="button" aria-pressed="false" aria-label="Read more about some awesome article title" target="_blank" rel="noopener">Join To Team</a> -->
                <div class="icon">
                    <i class="fa-solid fa-sun" id="icon"></i>
                </div>

                <div class="openMenu" aria-pressed="false" onclick="show()"><i class="fa-solid fa-bars"></i></div>
            </div>


    </header>

    <script src="./JS/index.js"></script>
    <script src="./JS/reveal.js"></script>
    <script src="./JS/ajax.js"></script>

    
</body>

</html>