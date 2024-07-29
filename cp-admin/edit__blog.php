<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {
    $errorWrite = $errorPic = $errorDate = $errorTitle = $errorContent = $errorTag = '';
    $insertSQL = true;
    if (isset($_GET['id'])) {
        $id_blogs = mysqli_real_escape_string($conn, $_GET['id']);
        $querySelect = "SELECT * FROM blogs WHERE id_blogs = '$id_blogs'";
        $resultSelect = mysqli_query($conn, $querySelect);

        if (mysqli_num_rows($resultSelect) > 0) {
            $row = mysqli_fetch_assoc($resultSelect);
            $id_blogs = $row['id_blogs'];
            $write = $row['writeBy'];
            $title = $row['title'];
            $content = $row['content'];
            $picture = $row['image'];
            $tags = $row['tags'];
            $date = $row['DateAdd'];
           
        } else {
            echo "<script>alert('Blog ID is not provided.'); window.location = 'index.php?page=blog';</script>";
        }
    } else {
        header("Location: index.php?page=blog");
        die();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {


        $write = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['write']))));
        $date = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['date']))));
        $title = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['title']))));
        $content = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['content']))));
        $tags = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['tags']))));

        if (!is_dir(__DIR__ . '/picBlog/')) {
            mkdir(__DIR__ . '/picBlog/', 0755, true);
        }

        // Check if a file was uploaded
        if (!empty($_FILES['picture']['name'])) {
            $allowed = ['jpeg', 'jpg', 'png'];
            $picture = $_FILES['picture']['name'];
            $tempName = $_FILES['picture']['tmp_name'];
            $folder = __DIR__ . '/picBlog/' . $picture;
            
            $file_extension = strtolower(pathinfo($folder, PATHINFO_EXTENSION));

            // Check file extension
            if (!in_array($file_extension, $allowed)) {
                $insertSQL = false;
            } else {
                move_uploaded_file($tempName, $folder);
            }
        }
        

        // Filter Write
        if (empty($write)) {
            $errorWrite = "<p style='color:#dc3545;'>Please Don't forget Writer blog is important!</p>";
            $insertSQL = false;
        }
        // Filter Date 
        if (empty($date)) {
            $errorDate = "<p  class='msg' style='color:#dc3545;'>Please Choose Date</p>";
            $insertSQL = false;
        } elseif (strtotime($date) < strtotime(date('Y-m-d'))) {
            $errorDate = "<p class='msg' style='color:#dc3545;'>Invalid Date</p>";
            $insertSQL = false;
        }
        // Filter Title 
        if (empty($title)) {
            $errorTitle = "<p style='color:#dc3545;'>Please Don't forget title blog is important!</p>";
            $insertSQL = false;
        }
        // Filter Content
        if (empty($content)) {
            $errorContent = "<p style='color:#dc3545;'>Please Don't forget content blog is important!</p>";
            $insertSQL = false;
        }
        // elseif (strlen($content) > 2000 && !is_null($content)) {
        //     $errorContent = "<p style='color:#dc3545;'>Please fill in 2000 characters</p>";
        //     $insertSQL = false;
        // }

        // Insert Into DataBase
        if ($insertSQL) {
            $query = "UPDATE blogs SET  writeBy = '$write', title = '$title', content = '$content', image = '$picture',tags = '$tags', DateAdd = '$date' WHERE id_blogs = '$id_blogs'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "<script>alert('Data Update Successfully'); window.location = 'index.php?page=blog';</script>";
            }
            
        } else {
            echo "<script>alert('No Data Insert');</script>";
        }
    }
}
// Close the database connection
mysqli_close($conn);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- AWESOME ICON FILE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Edit Blog</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "poppins", sans-serif;
        }
        body {
            width: 100%;
            min-height: 100svh;
            background-color: #e7e7e7;
        }

        .container {
            /* background-color: red; */
            width: 80%;
            height: 100%;
            margin: 0 auto;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .container h1 {
            font-size: clamp(12px, 3vw, 25px);
            text-transform: capitalize;
        }

        .container form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .container form label {
            font-size: clamp(11px, 3vw, 18px);
            text-transform: capitalize;
        }


        .container form input[type='file'] {
            background: var(--color-first);
            padding: 2%;
            border-radius: 5px;
            font-size: clamp(11px, 3vw, 15px);
        }

        .container form input::file-selector-button {
            font-weight: bold;
            padding: 1em;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            background-color: var(--color-box);
            color: var(--color-black);
        }

        .container form #date {
            border: none;
            padding: 2%;
            font-size: clamp(11px, 3vw, 15px);
            cursor: pointer;
            outline: none;
        }

        .container form #write,
        .container form #title,
        .container form #tags {
            width: 50%;
            height: 33px;
            padding: 2%;
            border: none;
            outline: none;
            border-radius: 5px;
        }

        .container form #title:focus {
            border: none;
            outline: none;

        }

        .container form #content {
            border: none;
            outline: none;
            resize: none;
            border-radius: 5px;
        }

        .container form #content:focus {
            border: none;
            outline: none;
        }

        .container form #title::placeholder,
        .container form #content::placeholder {
            padding: 2%;
            font-size: 1em;
            font-weight: 700;
            text-transform: uppercase;
            text-align: center;

        }

        .container button {
            padding: 10px 14px;
            border-radius: 22px;
            color: var(--color-black);
            font-size: clamp(11px, 3vw, 16px);
            font-weight: 400;
            text-decoration: none;
            background-color: #2ebbd4;
            cursor: pointer;
            border: none;
            outline: none;
        }

        @media screen and (max-width:539px) {
            .container {
                width: 100%;
            }

            .container form input[type='file'],
            .container form #write,
            .container form #title,
            .container form #content,
            .container form #tags {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Blog</h1>

        <form action="" method="POST" enctype="multipart/form-data">

        <label for="picture">Edit Picture:</label>
            <span><?php echo $errorPic; ?></span>
            <input type="file" name="picture" id="picture" hidden />
            <span id="messagePicture" value="<?php echo $picture;?>"><?php echo $picture;?></span>
            <button type="button" id="custom__button">CHOOSE A FILE</button>
              
            <label for="write">Write By:</label>
            <span><?php echo $errorWrite; ?></span>
            <input type="text" name="write" id="write" value="<?php echo $write; ?>">

            <label for="date">Edit Date:</label>
            <span><?php echo $errorDate; ?></span>
            <input type="date" name="date" id="date" value="<?php echo $date; ?>">

            <label for="title">Edit Title Blog:</label>
            <span><?php echo $errorTitle; ?></span>
            <input type="text" name="title" id="title" placeholder="Title Blog" value="<?php echo $title; ?>">



            <label for="content">Edit Text Content:</label>
            <span><?php echo $errorContent; ?></span>
            <textarea name="content" id="content" cols="80" rows="20" placeholder="Text Content"><?php echo $content; ?></textarea>

            <label for="tags">Add Tag</label>
            <span><?php echo $errorTag; ?></span>
            <input type="text" name="tags" id="tags" placeholder="Add tags blog" value="<?php echo $tags; ?>">


            <button type="submit" value="submit" name="submit"><i class="fa-solid fa-pen-to-square"></i> &nbsp Edit Blog</button>
        </form>
    </div>

    </form>

    <script>
        const picture = document.getElementById("picture");
        const customBtn = document.getElementById("custom__button");
        const messagePicture = document.getElementById("messagePicture");

        customBtn.addEventListener("click", ()=> {
            picture.click();
        });

        picture.addEventListener("change", ()=> {
            picture.value ? messagePicture.textContent = picture.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1] : messagePicture.textContent = "No file chosen, yet.";
        });
         
    </script>
</body>

</html>