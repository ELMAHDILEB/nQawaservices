<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {
    $errorWrite = $errorPic = $errorDate = $errorTitle = $errorContent = $errorTag  = '';
    $insertSQL = true;
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {


        $write = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['write']))));

        $allowed = ['jpeg', 'jpg', 'png'];
        $picture = $_FILES['picture']['name'];
        $tempName = $_FILES['picture']['tmp_name'];
        $folder = __DIR__ . '/picBlog/' . $picture;

        $date = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['date']))));
        $title = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['title']))));
        $content = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['content']))));
        $tags = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['tags']))));

        if (!is_dir(__DIR__ . '/picBlog/')) {
            mkdir(__DIR__ . '/picBlog/', 0755, true);
        }

        $file_extension = strtolower(pathinfo($folder, PATHINFO_EXTENSION));
        // Check Type Picture 
        if (!in_array($file_extension, $allowed)) {
            $errorPic = "<p style='color:#dc3545;'>NON UPLOADED: Invalid file type.</p>";
            $insertSQL = false;
        } else {
            move_uploaded_file($tempName, $folder);
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
        // Filter tags
        if (empty($tags)) {
            $errorTag = "<p style='color:#dc3545;'>Please Don't forget tags blog is important!</p>";
            $insertSQL = false;
        }elseif(ctype_alpha($tags)){
            $errorTag = "<p style='color:#dc3545;'>Please Tags must be in letters!</p>";
            $insertSQL = false;
        }
        // Insert Into DataBase
        if ($insertSQL) {
            $query = "INSERT INTO blogs(writerBy,title,content,image,tags,DateAdd) VALUES('$write','$title', '$content', '$picture','$tags','$date')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                header('Location: index.php?page=blog');
            }
            $msgUploaded = "<p style='color:#198754;border:none;padding:14px 20px;background-color:var(--color-second);';'>Uploaded successfully</p>";
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
    <title>Add Blog</title>
    <style>
        body {
            width: 100%;
            min-height: 100svh;
            color: var(--color-black);
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
            .container form #content ,
            .container form #tags{
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add New Blog</h1>


        <form action="" method="POST" enctype="multipart/form-data">

            <label for="write">Write By:</label>
            <span><?php echo $errorWrite; ?></span>
            <input type="text" name="write" id="write">

            <label for="picture">Add Picture</label>
            <span><?php echo $errorPic; ?></span>
            <input type="file" name="picture" id="picture" hidden />
            <span id="messagePicture">No file chosen, yet.</span>
            <button type="button" id="custom__button">CHOOSE A FILE</button>


            <label for="date">Add Date:</label>
            <span><?php echo $errorDate; ?></span>
            <input type="date" name="date" id="date" value="<?php if (isset($_POST['date'])) echo $_POST['date']; ?>">

            <label for="title">Add Title Blog</label>
            <span><?php echo $errorTitle; ?></span>
            <input type="text" name="title" id="title" placeholder="Title Blog" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">



            <label for="content">Add Text Content</label>
            <span><?php echo $errorContent; ?></span>
            <textarea name="content" id="content" cols="80" rows="20" placeholder="Text Content"><?php if (isset($_POST['content'])) echo $_POST['content']; ?></textarea>
             
            <label for="tags">Add Tag</label>
            <span><?php echo $errorTag; ?></span>
            <input type="text" name="tags" id="tags" placeholder="Add tags blog" value="<?php if (isset($_POST['tags'])) echo $_POST['tags']; ?>">
           
            <button type="submit" name="submit">+ &nbsp Add Blog</button>
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