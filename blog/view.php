<?php
require_once("../db/conn.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


$id_blogs = isset($_GET['id_blogs']) ? (int)$_GET['id_blogs'] : 1;

$query = "SELECT * FROM blogs WHERE id_blogs = '$id_blogs'";
$run = mysqli_query($conn, $query);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META START -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="<?php echo $content;?>">
    <meta name="keywords" content="<?php echo $tags;?>">
    <meta name="author" content="<?php echo $write;?>">
    <meta name="theme-color" content="#4285f4" />
    <!-- META END -->
    <!-- GOOGLE FONT FILE -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- CSS STYLE FILE -->
    <link rel="stylesheet" href="style.css">
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Blog</title>
    <style>
        body {
            width: 100%;
            min-height: 100svh;
            background-color: var(--color-second);
        }

        #page__blog {
            width: 80%;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 50px auto;
            overflow: hidden;
            color: var(--color-black);

        }

        #page__blog .marquee {
            position: relative;
            width: 80%;
            background-color: var(--color-first);
        }

        #page__blog .marquee .icon__marquee {
            font-size: clamp(12px, 3vw, 20px);
            position: absolute;
            z-index: 2;
            width: 44px;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 14px;
            background-color: var(--color-first);
        }

        #page__blog .marquee marquee {
            padding: 10px;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #page__blog .marquee marquee a {
            font-size: 1em;
            color: var(--color-black);
            text-transform: capitalize;
        }

        #page__blog h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: clamp(12px, 3vw, 20px);
            font-weight: 500;

        }

        #page__blog picture {
            width: 80%;
            height: 40%;
            display: block;
        }

        #page__blog picture img {
            width: 100%;
            height: 100%;
        }

        .primary__title {
            font-size: clamp(15px, 3vw, 23px);
        }

        .context::first-letter {
            text-transform: uppercase;
            font-size: 2em;
            font-weight: 900;
        }
    </style>
</head>

<body>

    <?php include('../header.php'); ?>

    <!-- /*BLOG PAGE START*/ -->

    <section id="page__blog">
        <?php
        if (mysqli_num_rows($run) > 0) {
            while ($row = mysqli_fetch_assoc($run)) {
        ?>
                <div class="marquee">
                    <div class="icon__marquee">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <marquee behavior="smooth" direction="ltr">
                        <?php
                        $titleQuery = "SELECT id_blogs, title FROM blogs LIMIT 5";
                        $result = mysqli_query($conn, $titleQuery);

                        if (mysqli_num_rows($result) > 0) {
                            while ($sub_row = mysqli_fetch_assoc($result)) {
                                echo '<a href="view.php?id_blogs=' . $sub_row['id_blogs'] . '">' . $sub_row['title'] . ' - </a>';
                            }
                        }
                        ?>
                    </marquee>
                </div>
                <h1 class="primary__title"><?= $row['title'] ?></h1>
                <h2><i class="fa-solid fa-pen-to-square"></i><?= $row['writeBy'] ?></h2>
                <p class="date"><i class="fa-regular fa-calendar"></i> <?= $row['DateAdd'] ?></p>
                <picture>
                    <img srcset="
                    ../cp-admin/picBlog/<?= $row['image'] ?> 200w,
                    ../cp-admin/picBlog/<?= $row['image'] ?> 593w,
                    ../cp-admin/picBlog/<?= $row['image'] ?> 842w,
                    ../cp-admin/picBlog/<?= $row['image'] ?> 1400w,
            " src="../cp-admin/picBlog/<?= $row['image'] ?>" alt="<?= $row['title'] ?>" loading="lazy" decoding="async" />
                </picture>
                <p class="context"><?= $row['content'] ?></p>
        <?php
            }
        } else {
            echo "<p>This Blog Is not Available.</p>";
            echo "<a href='./index.php'>Click Here to return to blogs page</a>";
        }
        ?>
    </section>

    <!-- /*BLOG PAGE END*/ -->


    <!-- <?php include("../footer.php"); ?> -->

    <script src="../JS/index.js"></script>
</body>

</html>