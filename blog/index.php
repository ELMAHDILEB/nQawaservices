<?php
require_once("../db/conn.php");

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$id_blogs = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$num_per_page = 10;
$page = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1;
$start_from = max(0, ($page - 1) * $num_per_page);

$query = "SELECT * FROM blogs  LIMIT $start_from, $num_per_page";
$run = mysqli_query($conn, $query);


$total_records_query = "SELECT COUNT(*) AS total FROM blogs";
$total_records_result = mysqli_query($conn, $total_records_query);
$total_records = mysqli_fetch_assoc($total_records_result)['total'];
$total_pages = ceil($total_records / $num_per_page);



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
  <!-- GOOGLE FONT FILE -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- CSS STYLE FILE -->
  <link rel="stylesheet" href="./style.css">
  <!-- AWESOME ICON FILE -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Blog</title>
</head>

<body>

  <?php include('../header.php'); ?>





  <!-- BLOG START -->
  <section id="blog">
    <div class="top__section">
      <h1>Blogs</h1>

      <div class="search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" name="search" id="search" placeholder="Search Blogs">
      </div>
    </div>

    <div class="content__blog">
        <?php
           if(mysqli_num_rows($run)>0){
               while($row = mysqli_fetch_assoc($run)){

            
        ?>
      <div class="card__blog">
        <div class="backHover"></div>
        <picture>
        <img srcset="
        ../cp-admin/picBlog/<?= $row['image'] ?> 200w,
        ../cp-admin/picBlog/<?= $row['image'] ?> 593w,
        ../cp-admin/picBlog/<?= $row['image'] ?> 842w,
        ../cp-admin/picBlog/<?= $row['image'] ?> 1400w,
                " src="../cp-admin/picBlog/<?= $row['image'] ?>" alt="<?= $row['title']?>" loading="lazy" decoding="async" />
        </picture>
        <div class="desc">
          <p class="date"><?= $row['DateAdd']?></p>
          <h2><?= $row['title'] ?></h2>

          <a href="view.php?id_blogs=<?= $row['id_blogs']?>" class="read__more">Read More <span><i class="fa-solid fa-arrow-right-long"></i></span></a>

        </div>
      </div>


      <?php
   }
  }else {
    echo "<tr><td colspan='12' style='width:100%;text-align:center;padding:3%;font-size: clamp(11px, 2vw, 15px);'>No! Record Found</td></tr>";
} 
?>


    </div>


    <div class="pagination">
      <?php if ($page > 1) {
        echo "<a href='index.php?page=blog&page_number=" . ($page - 1) . "' class='arrowLeft'><i class='fa-solid fa-chevron-left'></i></a>";
      } ?>




      <?php

      for ($i = 1; $i < $total_pages; $i++) {
        echo '<a href="index.php?page=blog&page_number=' . $i . '" class="numPages">' . $i . '</a>';
      }
      ?>

      <?php if ($page < $total_pages) {
        echo "<a href='index.php?page=blog&page_number=" . ($page + 1) . "' class='arrowRight'><i class='fa-solid fa-chevron-right'></i></a>";
      } ?>

    </div>
  </section>
  <!-- BLOG END -->

  <!-- Footer Section -->
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
            <a href="#">sign up</a>
            <a href="#">Join to team</a>
            <a href="#">blog</a>
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
  <!-- Footer Section -->

  <!-- Scroll To Top With Arrow -->

  <a  class="scroll"><i class="fa-solid fa-arrow-up"></i></a>


  <script src="../JS/index.js"></script>
  <script>
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
</body>

</html>
<?php
mysqli_close($conn);
?>