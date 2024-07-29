<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../cp-team/login.php");
    exit();
} else {
    $nameError = $emailError = $subjectError = $contentError = '';
    $insertSQL = true;

    // SELECT DATA
    if (isset($_GET['id'])) {
        $idMessage = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT * FROM writeus WHERE id_message = '$idMessage'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $idMessage = $row['id_message'];
            $name = $row['name'];
            $email = $row['email'];
            $subject = $row['subject'];
            $content = $row['content'];
        } else {
            echo "<script>alert('Message not found.'); window.location = 'index.php?page=messages';</script>";
            exit();
        }
    } else {
        header("Location: index.php?page=messages");
        exit();
    }

    // UPDATE DATA
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {


        $name = isset($_POST['name']) ? htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['name'])))) : '';
        $email = isset($_POST['email']) ? htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['email'])))) : '';
        $subject = isset($_POST['subject']) ? htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['subject'])))) : '';
        $content = isset($_POST['content']) ? htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['content'])))) : '';
        

        if (empty($name)) {
            $nameError = "<p class='msg' style='color:#dc3545;'>Please don't forget the name.</p>";
            $insertSQL = false;
        }
        if (empty($email)) {
            $emailError = "<p class='msg' style='color:#dc3545;'>Please don't forget the email.</p>";
            $insertSQL = false;
        }
        if (empty($subject)) {
            $subjectError = "<p class='msg' style='color:#dc3545;'>Please don't forget the subject. It is important!</p>";
            $insertSQL = false;
        }
        if (empty($content)) {
            $contentError = "<p class='msg' style='color:#dc3545;'>Please don't forget the content. It is important!</p>";
            $insertSQL = false;
        }

        if ($insertSQL) {
            $sql = "UPDATE writeus SET name = '$name', email = '$email', subject = '$subject', content = '$content' WHERE id_message = '$idMessage'";
            $runningSQL = mysqli_query($conn, $sql);
            if ($runningSQL) {
                echo "<script>alert('Data updated successfully.'); window.location = 'index.php?page=messages';</script>";
            } else {
                echo "<script>alert('Failed to update data.');</script>";
            }
        } else {
            echo "<script>alert('No data inserted.');</script>";
        }
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- AWESOME ICON FILE -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");


        :root {
            --color-black: rgb(0, 0, 0);
            --color-second: #e7e7e7;
            --color-box: #dcdcdc;
        }

        .dark__theme {
            --color-black: #fff;
            --color-second: rgb(0, 0, 0);
            --color-box: #0e1319;
        }

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;

            font-family: "Poppins", sans-serif;
        }

        body {
            width: 100%;
            background-color: #e7e7e7;
        }

        .container {
            width: 100%;
            padding: 2%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 40px;
        }

        .container h1 {
            font-size: clamp(18px, 5vw, 25px);
            text-transform: capitalize;
        }

        .container form {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .container form label {
            font-size: 16px;
        }

        .container form input {
            width: 300px;
            height: 30px;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 10px;
            transition: all 0.5s ease-in-out;
        }

        .container form input:focus {
            box-shadow: 0px 0px 2px 3px rgb(0, 0, 0, 10%);
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
        .status {
            border: none;
            outline: none;
            padding: 10px 14px;
            background: var(--color-box);
            color: var(--color-black);
            text-transform: capitalize;
        }
        .container form #content::placeholder {
            padding: 2%;
            font-size: 1em;
            font-weight: 700;
            text-transform: uppercase;
            text-align: center;

        }


        .status option {
            text-transform: capitalize;
        }

        .container form button {
            font-size: clamp(10px, 2vw, 16px);
            padding: 10px 14px;
            font-weight: 400;
            text-decoration: none;
            color: black;
            border-radius: 22px;
            background-color: #2ebbd4;
            cursor: pointer;
            border: none;
            outline: none;
        }

        .msgError {
            font-size: clamp(10px, 2vw, 16px);
            font-weight: 500;
            text-transform: capitalize;
            color: red;
        }
    </style>
    <title>Edit Message</title>
</head>

<body>
    <div class="container">
        <h1>Edit Message :</h1>
        <form action="" method="POST">
            <label for="type">Name :</label>
            <span><?php echo $nameError; ?></span>
            <input type="text" name="type" id="type" placeholder="John Deo" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">

            <label for="username">E-mail :</label>
            <span><?php echo $emailError; ?></span>
            <input type="text" name="username" id="username" placeholder="example@mail.com" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" />

            <label for="fullname">Subject :</label>
            <span><?php echo $subjectError; ?></span>
            <input type="text" name="fullname" id="fullname" placeholder="Example For Subject..." value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>" />

            <label for="content">Edit Text Content:</label>
            <span><?php echo $contentError; ?></span>
            <textarea name="content" id="content" cols="80" rows="20" placeholder="Text Content"><?php echo isset($content) ? htmlspecialchars($content) : ''; ?></textarea>
            

            <button type="submit" name="submit"><i class="fa-solid fa-pen-to-square"></i> &nbsp Edit Message </button>
        </form>
    </div>
</body>

</html>