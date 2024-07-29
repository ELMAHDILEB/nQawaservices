<?php
require_once('../db/conn.php');
session_start();

if (!isset($_SESSION['fullname'])) {
    header('Location: login.php');
    exit();
} else {
    $errorPic = $errorContent = $msgUploaded = '';
    $insertSQL = true;
    $userId = $_SESSION['idUser'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $picture_name = basename($_FILES['picture']['name']);
        $temp_name = $_FILES['picture']['tmp_name'];
        $folder = __DIR__ . '/pic/' . $picture_name;
        $allowed = ['jpeg', 'jpg', 'png'];
        $content = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST["content"]))));



        if (!is_dir(__DIR__ . '/pic/')) {
            mkdir(__DIR__ . '/pic/', 0755, true);
        }

        $file_extension = strtolower(pathinfo($folder, PATHINFO_EXTENSION));
        // Check Type Picture 
        if (!in_array($file_extension, $allowed)) {
            $errorPic = "<p style='color:#dc3545;'>NON UPLOADED: Invalid file type.</p>";
            $insertSQL = false;
        } else {
            move_uploaded_file($temp_name, $folder);
        }
        // filter Content 
        if (empty($content)) {
            $errorContent = "<p style='color:#dc3545;'>Content is required </p>";
            $insertSQL = false;
        } elseif (strlen($content) > 200 && !is_null($content)) {
            $errorContent = "<p style='color:#dc3545;'>Please fill in 30 Words</p>";
            $insertSQL = false;
        }

        if ($insertSQL) {
            $query = "INSERT INTO opinions(idUser, picture, content) VALUES('$userId', '$picture_name', '$content')";
            $result = mysqli_query($conn, $query);
            $msgUploaded = "<p style='color:#198754;border:none;padding:14px 20px;background-color:var(--color-second);';'>Uploaded successfully</p>";
        } else {
            echo "<script>alert('No Data Insert');</script>";
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
        <title>Add Testimonial</title>
        <!-- Style Css -->
        <style>
            :root {
                --color-text: #fff;
                --color-black: black;
                --color-first: #2ebbd4;
                --color-second: #e7e7e7;
                --color-hover: #75d2e3;
                --hover-two: #75d2e380;
                --color-box: #dcdcdc;


            }

            .dark__theme {
                --color-text: rgb(0, 0, 0);
                --color-black: #fff;
                --color-first: #0e1319;
                --color-second: rgb(0, 0, 0);
                --color-hover: #1f2936;
                --color-box: #0e1319;

            }

            body {
                background-color: var(--color-second);
            }

            form {
                width: 80%;
                height: auto;
                margin: 0 auto;
                display: block;
                padding: 4%;
                color: var(--color-black);
            }

            .content {
                background-color: var(--color-box);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 20px;
                padding: 2% 0;
            }

            .content label {
                font-size: 15px;
                font-weight: 600;
                text-transform: capitalize;
            }

            .content input[type='file'] {
                background: var(--color-second);
                padding: 2%;
                border-radius: 5px;
            }

            #picture::file-selector-button {
                font-size: clamp(14px, 3vw, 17px);
                font-weight: bold;
                text-transform: capitalize;
                color: var(--color-black);
                background-color: var(--color-first);
                padding: 0.5em;
                border-radius: 3px;
                border: none;
                outline: none;
                cursor: pointer;
            }

            .content textarea {
                width: 300px;
                height: auto;
                resize: none;
                outline: none;
                border: none;
                border-radius: 5px;
                padding: 5px;
                margin-bottom: 10px;
            }

            .content input[type='text'] {
                width: 300px;
                height: 30px;
                outline: none;
                border: none;
                border-radius: 5px;
                padding: 5px;
                margin-bottom: 10px;
            }

            .content button {
                padding: 10px 30px;
                border-radius: 22px;
                color: var(--color-black);
                text-decoration: none;
                text-transform: capitalize;
                font-size: clamp(11px, 3vw, 16px);
                font-weight: 400;
                background: linear-gradient(to right, var(--color-first) 50%, var(--color-hover) 50%) left;
                background-size: 200%;
                transition: 0.5s ease-out;
                cursor: pointer;
                border: none;
                margin-bottom: 10px;
            }

            .content button:hover {
                background-position: right;
            }

            @media (max-width:450px) {
                form {
                    width: 100%;
                    padding-top: 75px;
                }

                form h1 {
                    font-size: 17px;
                }

                .content :is(input[type='file'], textarea, input[type='text']) {
                    width: 277px;
                }

            }
        </style>
    </head>

    <body>
        <?php include('header.php'); ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST' enctype="multipart/form-data">
            <h1>Add Testimonial</h1>
            <div class="content">
                <span><?= $msgUploaded; ?></span>

                <label for="picture">add picture</label>
                <span><?php echo $errorPic; ?></span>
                <input type="file" name="picture" id="picture" hidden value="<?php if (isset($_POST['picture'])) echo $_POST['picture']; ?>">
                <span id="messagePicture">No file chosen, yet.</span>
                <button type="button" id="custom__button">Choose a file</button>

                <label for="testimonial">Add Your Testimonial</label>
                <span><?php echo $errorContent; ?></span>
                <textarea name="content" id="testimonial" cols="30" rows="10" placeholder="Add Your Testimonial"><?php if (isset($_POST['content'])) echo $_POST['content']; ?></textarea>
                <h4>character of the text: <span id="chars">0</span></h4>
                <h4>words of the text: <span id="words">0</span></h4>
                <button type="submit" name="submit">+ &nbsp Add Testimonial</button>

            </div>
        </form>
        <script>
            let testimonial = document.getElementById("testimonial");
            let chars = document.getElementById("chars");
            let words = document.getElementById("words");

            testimonial.addEventListener("input", ()=>{
                if(testimonial.value.trim() == ""){
                    chars.textContent = 0;
                    words.textContent = 0;
                    return false
                }
                let content = testimonial.value.split(" ").length;
                chars.textContent = testimonial.value.length;
                words.textContent = content;

                content > 30 ? words.style.color = "red" : words.style.color = "green";
                
            })

            let picture = document.querySelector("#picture");
            let custom__button = document.querySelector("#custom__button");
            let messagePicture = document.querySelector("#messagePicture");

            custom__button.addEventListener("click", ()=>{
                picture.click();
            });
            picture.addEventListener("change",()=>{
             picture.value ? messagePicture.textContent = picture.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1] : messagePicture.textContent = "No file chosen, yet.";
            });
        </script>
    </body>

    </html>
<?php } ?>