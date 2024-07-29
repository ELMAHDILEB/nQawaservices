<?php
session_start();
require_once('../db/conn.php');
if (!isset($_SESSION['idUser'])) {
    header('Location: login.php');
    exit();
} else {
    $errorUpPassword = '';
    $insertSQL = true;
    $userID = $_SESSION['idUser'];
    $selectRegister = "SELECT username, fullname, email FROM register WHERE id = $userID";
    $execute = mysqli_query($conn, $selectRegister);
    $rows = mysqli_fetch_all($execute, MYSQLI_ASSOC);


    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {

        $newPassword = htmlentities(mysqli_real_escape_string($conn, trim(stripslashes($_POST['newPassword']))));

        if (empty($newPassword)) {
            $errorUpPassword = "<p style='color:#dc3545;'>The field is empty, please fill it in</p>";
            $insertSQL = false;
        } elseif (mb_strlen($newPassword) < 8) {
            $errorUpPassword = "<p style='color:#dc3545;'>Please fill in the field with more than 8 characters!</p>";
            $insertSQL = false;
        }

        if ($insertSQL) {
            $query = "UPDATE register SET password = '" . hash('sha256', $newPassword) . "' WHERE id = '{$_SESSION['idUser']}' ";
            $result = mysqli_query($conn, $query);
            $errorUpPassword = "<p style='color:#198754;'>The change has been made successfully</p>";
        }
    }


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- Style CSS -->
        <style>
            :root {
                --color-text: #fff;
                --color-black: rgb(0, 0, 0, );
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

            body {
                background-color: var(--color-second);
                position: relative;
            }

            main {
                width: 80%;
                margin: 25px auto;
                height: auto;
                padding: 4%;
                color: var(--color-black);
            }

            .content {
                width: 100%;
                min-height: 400px;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-around;
                gap: 20px;
                padding: 6%;
                background: var(--color-box);
            }

            .content__left {
                width: 400px;
                height: 200px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 10px;
                background-color: var(--color-second);
                padding: 2%;
            }
            .content__left .emoji{
                font-size:clamp(14px, 3vw, 2em);
            }
            .content__left p {
                font-size: 16px;
                font-weight: 600;
                color: var(--color-black);
            }

            .content__right {
                width: 400px;
                height: 200px;
                background-color: var(--color-second);
            }

            .content__right form {
                width: 100%;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }


            .content__right label {
                font-size: 15px;
                font-weight: 600;
                text-transform: capitalize;
            }

            .content__right input {
                width: 300px;
                height: 30px;
                outline: none;
                border: none;
                border-radius: 5px;
                padding: 5px;
                margin-bottom: 10px;
            }

            .content__right button {
                padding: 10px 30px;
                border-radius: 22px;
                color: white;
                text-decoration: none;
                text-transform: capitalize;
                font-size: 16px;
                font-weight: 400;
                background: linear-gradient(to right, var(--color-first) 50%, var(--color-hover) 50%) left;
                background-size: 200%;
                transition: 0.5s ease-out;
                cursor: pointer;
                border: none;
                margin-bottom: 10px;
            }

            .content__right button:hover {
                background-position: right;
            }

            @media (max-width:447px) {
                main {
                    width: 100%;
                }

                .content__right input {
                    width: 250px;
                }
            }

            @media (max-width:323px) {

                .content__left p {
                    font-size: 12px;
                }

                .content__right input {
                    width: 250px;
                }
            }
        </style>
    </head>

    <body>
        <?php include('header.php'); ?>

        <main>
            <h1>Edit Account</h1>
            <div class="content">
                <div class="content__left">

                    <?php
                    foreach ($rows as $row) {
                        $fullname = $row['fullname'];
                        $username = $row['username'];
                        $email = $row['email'];
                    }
                    ?>

                    <p>welcome: <?php echo $fullname; ?> <span class="emoji"> &#128075;</span></p>
                    <p>Username: <?php echo $username; ?></p>
                    <p>Email: <?php echo $email; ?></p>

                </div>
                <div class="content__right">
                    <form action="" method="post">

                        <label for="newPassword">new Password</label>
                        <span><?php echo $errorUpPassword; ?></span>
                        <input type="password" name="newPassword" placeholder="New Password" id="newPassword">
                        <button type="submit" name="submit" value="Edit">Edit</button>
                    </form>
                </div>



            </div>
        </main>
    </body>

    </html>
<?php } ?>