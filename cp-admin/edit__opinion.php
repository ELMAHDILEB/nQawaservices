<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {
    $errorContent = '';
    $insertSQL = true;

    if (isset($_GET['id'])) {
        $id_opinion = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT * FROM opinions WHERE id_opinion = '$id_opinion'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id_opinion = $row['id_opinion'];
            $content = $row['content'];
            $status = $row['status'];
        } else {
            echo "<script>alert('Opinion ID is not provided.')</script>";
            sleep(3);
            header("Location: index.php?page=opinions");
            exit();
        }
    } else {
        header("Location: index.php?page=opinions");
        die();
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["submit"])) {

        $content = stripslashes(trim(mysqli_real_escape_string($conn, $_POST['content'])));
        $status = stripslashes(trim(mysqli_real_escape_string($conn, $_POST['status'])));

        if ($insertSQL) {

            $sql = "UPDATE opinions SET content = '$content', status = '$status' WHERE `id_opinion` = '$id_opinion'";
            $rsl = mysqli_query($conn, $sql);


            if ($rsl) {
                echo "<script>alert('Data Update Successfully');</script>";
                echo "<script>window.location = 'index.php?page=opinions';</script>";
            } else {
                echo "<script>alert('Failed to insert data');</script>";
            }
        }
    } else {

        echo "<script>window.location = 'edit__opinion.php?id=" . $row['id_opinion'] . ";</script>";
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
    <title>Edit Booking</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");

        :root {

            --color-black: black;
            --color-first: #2ebbd4;
            --color-hover: #75d2e3;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: "poppins", sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: #e7e7e7;
        }

        .layout {
            width: 100%;
            height: 100%;
        }

        .layout form {
            width: 80%;
            height: 100%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            flex-direction: column;
        }

        .layout form textarea {
            width: 300px;
            height: auto;
            resize: none;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 5px;
        }
        .layout form select {
            background: white;
            border: none;
            outline: none;
            padding: 1% 2%;
            font-weight: 700;
            cursor: pointer;
        }

        .layout form button {
            padding: 10px 30px;
            border-radius: 22px;
            color: var(--color-black);
            text-decoration: none;
            text-transform: capitalize;
            font-size: clamp(11px, 3vw, 16px);
            font-weight: 400;
            background-color: var(--color-first);
            transition: all 0.5s ease-out;
            cursor: pointer;
            border: none;
        }

        .layout form button:hover {
            background-color: var(--color-hover);
        }

    </style>

</head>

<body>
    <div class="layout">

        <form action="" method="POST">
            <h1>Edit Testimonial</h1>


            <span><?php echo $errorContent; ?></span>
            <textarea name="content" id="testimonial" cols="30" rows="10" placeholder="Add Your Testimonial"><?php echo $content; ?></textarea>
            <h4>character of the text: <span id="chars">0</span></h4>
            <h4>words of the text: <span id="words">0</span></h4>

            <label>Status :</label>
            <select name="status" class="status">
                <option value="in progress" <?php if ($status == 'in progress') echo 'selected="selected"'; ?>>In Progress</option>
                <option value="accept" <?php if ($status == 'accept') echo 'selected="selected"'; ?>>Accept</option>
            </select>
            <button type="submit" name="submit"><i class="fa-solid fa-pen-to-square"></i> &nbsp Edit Testimonial</button>
        </form>

    </div>

    <script>
        let testimonial = document.getElementById("testimonial");
        let chars = document.getElementById("chars");
        let words = document.getElementById("words");

        testimonial.addEventListener("input", () => {
            if (testimonial.value.trim() == "") {
                chars.textContent = 0;
                words.textContent = 0;
                return false
            }
            let content = testimonial.value.split(" ").length;
            chars.textContent = testimonial.value.length;
            words.textContent = content;

            content > 30 ? words.style.color = "red" : words.style.color = "green";

        })
    </script>
</body>

</html>