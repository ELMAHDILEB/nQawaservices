<?php
require("./db/conn.php");
session_start();

// SELECT OPINIONS AND FULLNAMES FROM OPINIONS , REGISTER TABLES

$query = "SELECT opinions.*, register.fullname FROM opinions
          JOIN register ON opinions.idUser = register.id";
$result = mysqli_query($conn, $query);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

// MESSAGES RECEPTION  FROM CLIENT
$insertSQL = true;
$nameError = $emailError = $subjectError = $contentError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $name = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['name']))));
    $email = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['email']))));
    $subject = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['subject']))));
    $content = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['content']))));


    // filtering Name
    if (empty($name)) {
        $nameError = "<p style='color:#dc3545;'>Name Is required!</p>";
        $insertSQL = false;
    } elseif (strlen($name) < 8 || strlen($name) > 40) {
        $nameError = "<p style='color:#dc3545;'>The name must be between 8 and 20 characters</p>";
        $insertSQL = false;
    } elseif (!preg_match('/^[a-zA-Z ]+$/', $name)) {
        $nameError = "<p style='color:#dc3545;'>Name should only contain alphabetic characters</p>";
        $insertSQL = false;
    }
    // filtering EMAIL
    if (empty($email)) {
        $emailError = "<p style='color:#dc3545;'>E-mail Address Is required!</p>";
        $insertSQL = false;
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE) {
        $emailError = "<p style='color:#dc3545;'>Please Write Correct Email</p>";
        $insertSQL = false;
    }


    // filtering subject
    if (empty($subject)) {
        $subjectError = "<p style='color:#dc3545;'>Subject Is required!</p>";
        $insertSQL = false;
    } elseif (strlen($subject) < 20) {
        $subjectError = "<p style='color:#dc3545;'>The subject must be greater than 20 characters</p>";
        $insertSQL = false;
    } elseif (!preg_match('/^[a-zA-Z ]+$/', $subject)) {
        $subjectError = "<p style='color:#dc3545;'>Subject should only contain alphabetic characters</p>";
        $insertSQL = false;
    }

    // filtering content
    if (empty($content)) {
        $contentError = "<p style='color:#dc3545;'>Content Is required!</p>";
        $insertSQL = false;
    } elseif (strlen(($content) < 100)) {
        $contentError = "<p style='color:#dc3545;'>The Content must be greater than 100 characters</p>";
        $insertSQL = false;
    }

    // INSERT DATA 

    if($insertSQL){
         $queryWriteUs  = "INSERT INTO writeus(name, email, subject, content) VALUES('$name', '$email', '$subject', '$content')";
         $runningQueryWriteUs = mysqli_query($conn, $queryWriteUs);
            echo "<script>alert('Message sent Successfully'); window.location = './';</script>";
      
    }else {
        echo "<script>alert('Message No sent')</script>";
    }







} 





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="alternate" href="https://example.com" hreflang="x-default" />
    <!-- META START -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Immerse yourself in the ultimate combination of cleanliness and comfort with GoodHome. Our dedicated team delivers exceptional cleaning services, transforming your space into a spotless haven of tranquility. Experience the joy of a pristine and inviting living environment with us.">
    <meta name="keywords" content="cleaning house job, cleaning house services, cleaning commercial services, cleaning services job, cleaning green spaces">
    <meta name="author" content="EL MAHDI BELCADI">
    <meta name="theme-color" content="#4285f4" />
    <!-- META END -->
    <!-- GOOGLE FONT FILE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- CSS STYLE FILE -->
    <link rel="stylesheet" href="css/style.css">
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Slick CDN -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SCROLL REVEAL -->
    <script src="./JS/reveal.js" defer></script>
    <script src="https://unpkg.com/scrollreveal"></script>


    <title>Services Cleaning</title>
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
                    <a href="./">
                        <h1><span>nQawa</span> Services</h1>
                    </a>
                </div>


                <nav>
                    <ul class="mobile">
                        <div class="closeMenu" aria-pressed="false" onclick="hide()"><i class="fa-solid fa-xmark"></i>
                        </div>
                        <li><a href="./">home</a></li>
                        <li><a href="#about">about</a></li>
                        <li><a href="#services">services</a></li>
                        <li><a href="#contact">contact</a></li>
                        <li><a href="./blog/">blog</a></li>

                    </ul>
                    <ul class="list">
                        <li><a href="./">home</a></li>
                        <li><a href="#about">about</a></li>
                        <li><a href="#services">services</a></li>
                        <li><a href="#contact">contact</a></li>
                        <li><a href="./blog/">blog</a></li>

                    </ul>
                </nav>
                <!-- <a href="#" class="button" role="button" aria-pressed="false" aria-label="Read more about some awesome article title" target="_blank" rel="noopener">Join To Team</a> -->
                <div class="icon">
                    <i class="fa-solid fa-sun" id="icon"></i>
                </div>

                <div class="openMenu" aria-pressed="false" onclick="show()"><i class="fa-solid fa-bars"></i></div>
            </div>


    </header>


    <!-- Swiper -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="content">
                    <div>
                        <h1 class="title">Professional House Cleaning Services</h1>
                    </div>
                    <p class="paragraph">Make your home shine with cleanliness: Expert Housekeeping services at your disposal</p>
                </div>
                <img srcset="
                images/auto/slider1-200.jpg 200w,
                images/auto/slider1-593.jpg 593w,
                images/auto/slider1-842.jpg 842w,
                images/auto/slider1-1104.jpg 1104w,
                images/auto/slider1-1346.jpg 1346w,
                images/auto/slider1-1400.jpg 1400w,
                " src="images/auto/slider1.jpg" alt="slider1" loading="lazy" decoding="async" />

            </div>
            <div class="swiper-slide">
                <div class="content">
                    <div>
                        <h1 class="title">Professional commercial Cleaning Services</h1>
                    </div>
                    <p class="paragraph">Keep your business gleaming</p>
                </div>
                <img srcset="
                images/auto/slider2-200.jpg 200w,
                images/auto/slider2-542.jpg 542w,
                images/auto/slider2-982.jpg 982w,
                images/auto/slider2-1188.jpg 1188w,
                images/auto/slider2-1344.jpg 1344w,
                images/auto/slider2-1400.jpg 1400w,
                " src="images/auto/slider2.jpg" alt="slider2" loading="lazy" decoding="async" />
            </div>

            <div class="swiper-slide">
                <div class="content">
                    <div>
                        <h1 class="title">green cleaning services for outdoor spaces</h1>
                    </div>
                    <p class="paragraph">with our cleaning services preserve nature's beauty</p>
                </div>
                <img srcset="
                images/auto/slider3-200.jpg 200w,
                images/auto/slider3-563.jpg 563w,
                images/auto/slider3-834.jpg 834w,
                images/auto/slider3-1046.jpg 1046w,
                images/auto/slider3-1269.jpg 1269w,
                images/auto/slider3-1400.jpg 1400w,
                " src="images/auto/slider3.jpg" alt="slider3" loading="lazy" decoding="async" />
            </div>

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- About Section START -->
    <section id="about">
        <div class="primary__title zero">
            <h1>About the company</h1>
            <span tabindex="0"></span>
        </div>

        <div class="content__about">


            <picture>
                <img srcset="
                images/about/about-200.png 200w,
                images/about/about-356.png 3560w,
                images/about/about-474.png 474w,
                images/about/about-666.png 666w,
                images/about/about-749.png 749w,
                images/about/about-827.png 827w,
                images/about/about972.png 972w,
                
                " src="images/about/about.png" width="400px" alt="about" loading="lazy" decoding="async" />
            </picture>



            <div class="about__right">
                <div class="logo" style="text-align: center;">
                    <h1><span>nQawa</span> Services</h1>
                </div>

                <article>
                    <p>At n9awa Service, we take pride in offering you the ultimate choice in cleaning services. Whether you prefer our classic approach, characterized by our dedicated and experienced team, or our innovative method with robots we guarantee you superior quality service. Our goal is to meet your needs flexibly and efficiently, while ensuring a clean and welcoming environment for your spaces.</p>
                </article>
                <a href="#services" class="btn__services" target="_self" "noopener" aria-label="Read more about some awesome article title">View our sersvice</a>
            </div>
        </div>
    </section>
    <!-- About Section END -->

    <!-- Why Chose Me START -->
    <article id="article">
        <div class="primary__title two">
            <h1>Why Choose Us</h1>
        </div>
        <div class="chose">
            <figure>
                <img src="images/excellence.png" alt="excellence" width="10%" loading="lazy" decoding="async">
                <figcaption>Professional Excellence</figcaption>
            </figure>
            <figure>
                <img src="images/cleaning-products.png" alt="cleaning-products" width="10%" loading="lazy" decoding="async">
                <figcaption>Customized Cleaning Solutions</figcaption>
            </figure>
            <figure>
                <img src="images/sustainable.png" alt="sustainable" width="10%" loading="lazy" decoding="async">
                <figcaption>Green and Sustainable Practices</figcaption>
            </figure>
            <figure>
                <img src="images/dependable.png" alt="Reliable" width="10%" loading="lazy" decoding="async">
                <figcaption>Reliable and Trustworthy Service</figcaption>
            </figure>
        </div>

    </article>
    <!-- Why Chose Me END -->
    <!-- Services START  -->

    <section id="services">
        <div class="primary__title three">
            <h1>Choose the service</h1>
            <span tabindex="0"></span>
        </div>



        <ul class="choosing">
            <li id="classic">Classic cleaning</li>
            <li id="ai">Innovative cleaning</li>
        </ul>



        <div class="classic__card">
            <p>Adapted prices, experienced professionals, customization according to needs, satisfaction guaranteed.</p>

            <div class="all__classic__card">
                <div class="structure__card">

                    <img srcset="
                images/house-cleaning-190.jpg 190w,
                images/house-cleaning-617.jpg 617w,
                images/house-cleaning-856.jpg 856w,
             
                " src="images/house-cleaning.jpg" alt="house-cleaning" loading="lazy" decoding="async" />


                    <h2>House Cleaning</h2>

                    <a href="./cp-users/register.php" class="btn">book services</a>
                </div>
                <div class="structure__card">

                    <img srcset="
                images/commercial-cleaning-190.jpg 190w,
                images/commercial-cleaning-522.jpg 522w,
                images/commercial-cleaning-761.jpg 761w,
                images/commercial-cleaning-970.jpg 970w,
                images/commercial-cleaning-1161.jpg 1161w,
             
                " src="images/commercial-cleaning.jpg" alt="commercial-cleaning" loading="lazy" decoding="async" />


                    <h2>Commercial Cleaning</h2>


                    <a href="./cp-users/register.php" class="btn">book services</a>
                </div>
                <div class="structure__card">

                    <img srcset="
                images/green-clean-190.jpg 190w,
                images/green-clean-372.jpg 372w,
                images/green-clean-502.jpg 502w,
                images/green-clean-604.jpg 604w,
                images/green-clean-761.jpg 761w,
                images/green-clean-954.jpg 954w,
             
                " src="images/green-clean.jpg" alt="green-clean" loading="lazy" decoding="async" />

                    <img src="images/green-clean.jpg" alt="">
                    <h2>Green Clean</h2>


                    <a href="./cp-users/register.php" class="btn">book services</a>
                </div>
            </div>

        </div>

        <div class="ai__card active">
            <p>Programmable robots offering schedule flexibility, high efficiency, faster cleaning, technology service for trend followers</p>
            <div class="all__ai__card">

                <div class="structure__ai">

                    <img srcset="
                images/robot-vacuum-190.jpg 190w,
                images/robot-vacuum-628.jpg 628w,
                images/robot-vacuum-957.jpg 957w,
             
                " src="images/robot-vacuum.jpg" alt="robot-vacuum" loading="lazy" decoding="async" />


                    <h2>House Cleaning With Robot Vacuum</h2>


                    <a href="./cp-users/register.php" class="btn">book services</a>
                </div>
                <div class="structure__ai">

                    <img srcset="
                images/floor-scrubber-190.jpg 190w,
                images/floor-scrubber-417.jpg 417w,
                images/floor-scrubber-554.jpg 554w,
                images/floor-scrubber-727.jpg 727w,
             
                " src="images/floor-scrubber.jpg" alt="floor-scrubber" loading="lazy" decoding="async" />



                    <h2>Commercial Cleaning With Floor Scrubber</h2>


                    <a href="./cp-users/register.php" class="btn">book services</a>
                </div>
                <div class="structure__ai">


                    <img srcset="
                images/lawn-mower-190.jpg 190w,
                images/lawn-mower-424.jpg 424w,
                images/lawn-mower-587.jpg 587w,
                images/lawn-mower-691.jpg 691w,
                images/lawn-mower-808.jpg 808w,
             
                " src="images/lawn-mower.jpg" alt="lawn-mower" loading="lazy" decoding="async" />


                    <h2>Green Clean With Lawn Mower</h2>


                    <a href="./cp-users/register.php" class="btn">book services</a>
                </div>
            </div>



    </section>

    <!-- Services END  -->

    <!-- How It's Work START -->

    <section class="how__work">
        <div class="primary__title four">
            <h1>How It's Work</h1>
            <p>it's easy as <b>1,2,3,4</b></p>
        </div>
        <div class="all__card__work">

            <figure class="card__work">
                <picture>
                    <img src="images/call.png" alt="call">
                </picture>
                <h2>give us a call</h2>
            </figure>

            <figure class="card__work">
                <picture>
                    <img src="images/date.png" alt="date">
                </picture>
                <h2>schedule it</h2>
            </figure>

            <figure class="card__work">
                <picture>
                    <img src="images/mop.png" alt="mop">
                </picture>
                <h2>the cleaning</h2>
            </figure>

            <figure class="card__work">
                <picture>
                    <img src="images/cash-payment.png" alt="cash-payment">
                </picture>
                <h2>easy payment</h2>
            </figure>
        </div>

    </section>

    <!-- How It's Work END -->


    <!-- Team Member START  -->

    <section id="team">
        <div class="primary__title five">
            <h1>Team Member</h1>
            <span tabindex="0"></span>
        </div>

        <div class="all__card__member">


            <figure class="card__member">
                <picture>
                    <img srcset="
                images/team/men/men-200.png 200w,
                images/team/men/men-425.png 425w,
                images/team/men/men-585.png 585w,
                images/team/men/men-725.png 725w,
                images/team/men/men-948.png 948w,
                images/team/men/men-1053.png 1053w,
                
                " src="images/team/men/men.png" alt="men-team" loading="lazy" decoding="async" width="400px" height="300px" />
                </picture>
                <figcaption>James Rodri</figcaption>
            </figure>
            <figure class="card__member">

                <picture>
                    <img srcset="
                images/team/men2/men2-190.png 190w,
                images/team/men2/men2-298.png 298w,
                images/team/men2/men2-388.png 388w,
                images/team/men2/men2-453.png 453w,
                images/team/men2/men2-689.png 689w,
                images/team/men2/men2-703.png 703w,
                " src="images/team/men2/men2.png" alt="men2-team" loading="lazy" decoding="async" width="240px" height="300px" />
                </picture>
                <figcaption>Kevin Nolan</figcaption>
            </figure>
            <figure class="card__member">

                <picture>
                    <img srcset="
                    images/team/women/women-190.png 190w,
                    images/team/women/women-478.png 478w,
                    images/team/women/women-666.png 666w,
                    images/team/women/women-834.png 834w,
                    images/team/women/women-994.png 994w,
                    
                    " src="images/team/women/women.png" alt="women-team" loading="lazy" decoding="async" width="400px" height="300px" />
                </picture>
                <figcaption>Leila Smash</figcaption>
            </figure>

        </div>

    </section>

    <!-- Team Member END  -->

    <!-- Client Say START  -->

    <section id="client">
        <div class="primary__title six">
            <h1>Testimonials</h1>
            <p>hear from our clients</p>

        </div>
        <div class="all__card__client">
            <div class="slider responsive">

                <?php foreach ($rows as $row) :

                    if ($row['status'] == "accept") {



                ?>
                        <div class="client__card">
                            <picture>
                                <img srcset="
                        cp-users/pic/<?php echo $row['picture']; ?> 200w,
                        cp-users/pic/<?php echo $row['picture']; ?> 505w,
                        cp-users/pic/<?php echo $row['picture']; ?> 720w,
                        cp-users/pic/<?php echo $row['picture']; ?> 912w,
                        cp-users/pic/<?php echo $row['picture']; ?> 1053w,
                
                " src="cp-users/pic/<?php echo $row['picture']; ?>" alt="man1" loading="lazy" decoding="async" />
                            </picture>
                            <p><?php echo $row['content']; ?></p>
                            <em><?php echo $row['fullname']; ?></em>
                        </div>
                <?php    }
                endforeach; ?>
            </div>
    </section>

    <!-- Client Say END  -->

    <!-- Contact START -->

    <section id="contact">
        <div class="primary__title seven">
            <h1>Contact</h1>
            <span></span>
        </div>
        <div class="all__contact">


            <form action="" class="form__contact" method="POST">

                <h2>Write Us</h2>
                <label for="name">name:</label>
                <span><?php echo $nameError; ?></span>
                <input type="text" name="name" id="name">
                <label for="email">email:</label>
                <span><?php echo $emailError; ?></span>
                <input type="text" name="email" id="email">
                <label for="subject">subject:</label>
                <span><?php echo $subjectError; ?></span>
                <input type="text" name="subject" id="subject">
                <label for="message">message:</label>
                <span><?php echo $contentError; ?></span>
                <textarea name="content" id="message"></textarea>
                <button class="button" name="submit" aria-pressed="false" aria-label="Send Message" target="_blank" rel="noopener">Send Message</button>
            </form>


            <div class="contact__info">
                <h3>contact info <br>
                    <p style="font-size: 13px; padding-left: 15px;">We're open for any suggestion or just to have a chat
                    </p>
                </h3>

                <div class="all__one">
                    <div class="one">
                        <i class="fa-solid fa-phone"></i>
                        <span>+1 456-4567-1476</span>
                    </div>

                    <div class="one">
                        <i class="fa-solid fa-message"></i>
                        <span>goodhome@mail.com</span>
                    </div>

                    <div class="one">
                        <i class="fa-solid fa-location-pin"></i>
                        <span>12th Street South between Clark and Eads Streets, Arlington, VA 22202 </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact END -->

    <!-- Footer START -->

    <section id="footer">

        <div class="all__footer">
            <div class="news__letter">
                <h1>News Letter</h1>

                <input type="email" placeholder="Email Address">
                <button class="button" aria-pressed="false" aria-label="Send Message" target="_blank" rel="noopener">Send Message</button>
            </div>

            <div class="quick__link">

                <h1>Quick links</h1>
                <ul>
                    <li>
                        <a href="./cp-users/register.php">sign up</a>
                        <a href="./job.php">Join to team</a>
                        <a href="./blog/">blog</a>
                    </li>
                </ul>
            </div>

            <div class="support">

                <h1>support</h1>
                <ul>
                    <li>
                        <a href="#">faqs</a>
                        <a href="#">terms</a>
                        <a href="#">privacy</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>© CopyRight 2024 Design by BELCADI EL MAHDI</p>
        </div>
    </section>

    <!-- Footer END -->

    <!-- Scroll To Top With Arrow -->

    <a class="scroll"><i class="fa-solid fa-arrow-up"></i></a>

    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script type="text/javascript">
        //! Responsive Menu
        let closeMenu = document.querySelector(".closeMenu");
        let openMenu = document.querySelector(".openMenu");
        let menu = document.querySelector(".list");
        let menuMobile = document.querySelector(".mobile");

        function show() {
            menuMobile.style.transform = "translateX(0%)";
        }

        function hide() {
            menuMobile.style.transform = "translateX(-1000%)";
        }

        //!  Swiper Slider
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });


        //! Dark And Light Theme
        var isDarkTheme = localStorage.getItem("darkTheme") === "true";
        let body = document.body;
        var icon = document.getElementById("icon");

        if (isDarkTheme) {
            body.classList.add("dark__theme");
            icon.className = "fa-solid fa-sun";
        } else {
            body.classList.remove("dark__theme");
            icon.className = "fa-solid fa-moon";
        }

        icon.onclick = function() {
            body.classList.toggle("dark__theme");
            localStorage.setItem("darkTheme", body.classList.contains("dark__theme"));
            if (body.classList.contains("dark__theme")) {
                icon.className = "fa-solid fa-sun";
            } else {
                icon.className = "fa-solid fa-moon";
            }
        };

        //! Show And Hide In Box Services
        let classicBtn = document.getElementById("classic");
        let aiBtn = document.getElementById("ai");
        let classicCard = document.querySelector(".classic__card");
        let aiCard = document.querySelector(".ai__card");


        function toggleCards() {
            aiCard.classList.toggle("active");
            classicCard.classList.toggle("active");
            aiCard.classList.add("fade-in");
            classicCard.classList.add("fade-in");
        }

        aiBtn.addEventListener("click", toggleCards);
        classicBtn.addEventListener("click", toggleCards);

        // Scroll To Top
        let icon__scroll = document.querySelector(".scroll");
        let header = document.getElementById("header");
        window.addEventListener("DOMContentLoaded", () => {
            window.addEventListener("scroll", () => {
                document.documentElement.scrollTop >= 150 ? icon__scroll.style.cssText = `opacity: 1; visibility: visible;` : icon__scroll.style.cssText = `opacity: 0; visibility: hidden;`;
                document.documentElement.scrollTop > 0 ? header.classList.add("shadow") : header.classList.remove("shadow");
            })
        })

        icon__scroll.addEventListener("click", () => {
            window.scrollTo({
                behavior: 'smooth',
                top: 0
            })
        })
    </script>



    <!-- CDN jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Initialize Slider Slick -->
    <script type="text/javascript">
        $('.responsive').slick({
            dots: false,
            infinite: true,
            loop: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 2.5,
                        slidesToScroll: 2.5
                    }
                },
                {
                    breakpoint: 650,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }

            ]
        });
    </script>


</body>

</html>