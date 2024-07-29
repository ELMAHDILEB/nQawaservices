<?php
session_start();
require_once('../db/conn.php');

if (!isset($_SESSION['idUser'])) {
    header('Location: login.php');
    exit();
} else {
    $userID = $_SESSION['idUser'];


    // $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);


    $num_per_page = 15;
    $page = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1;
    $start_from = max(0, ($page - 1) * $num_per_page);

    $query = "SELECT booking.*, register.fullname 
              FROM booking
              JOIN register ON booking.idUser = register.id 
              WHERE booking.idUser = $userID 
              LIMIT $start_from, $num_per_page";

    $result = mysqli_query($conn, $query);

    $total_records_query = "SELECT COUNT(*) AS total FROM booking WHERE idUser = $userID";
    $total_records_result = mysqli_query($conn, $total_records_query);
    $total_records = mysqli_fetch_assoc($total_records_result)['total'];
    $total_pages = ceil($total_records / $num_per_page);


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Profile</title>
        <!-- Style CSS -->
        <style>
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

            * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }

            body {
                background-color: var(--color-second);
                width: 100%;
                height: 100vh;
            }

            section {
                position: relative;
                width: 100%;
                height: 100%;
                margin: 0 auto;
                padding: 3%;
                display: flex;
                flex-direction: column;
                justify-content: start;
                align-items: center;
                gap: 50px;
                color: var(--color-black);
            }

            .add__booking {
                text-transform: capitalize;
                text-decoration: none;
                font-weight: 700;
                background-color: #198754;
                border-radius: 5px;
                border: none;
                outline: none;
                color: var(--color-black);
                padding: 10px 15px;
                cursor: pointer;
                transition: background-color 0.5s ease-in-out;
            }

            .add__booking:hover {
                background-color: #1dc376;
            }

            .content {
                font-size: clamp(11px, 2vw, 14px);
                width: 100%;
                max-height: calc(100% - 1.6rem);
                overflow: overlay;
                background-color: var(--color-box);
            }

            .content table {
                width: 100%;
            }

            .content table thead {
                background: #bbbbbb;
            }

            th {
                padding: 10px;
                color: #2e2e2e;
            }

            th,
            td {
                text-align: start;
                border-bottom: 1px solid #ddd;
            }

            td {
                padding: 10px;
            }

            tr:nth-child(2n) {
                background: var(--color-second);
            }

            td>button {
                border: none;
                border-radius: 5px;
                outline: none;
                background-color: #dc3545;
                color: var(--color-black);
                padding: 10px 15px;
                cursor: pointer;
                transition: background-color 0.5s ease-in-out;
            }

            td>button:hover {
                background-color: #e84958;
            }

            .inProgress,
            .accept {
                font-size: clamp(11px, 2vw, 14px);
                font-weight: 600;
                text-transform: capitalize;
                text-align: center;
                padding: 10px 14px;
                border-radius: 5px;
            }

            .edit,
            .delete {
                text-decoration: none;
                font-weight: bold;
                border: none;
                border-radius: 5px;
                outline: none;
                color: var(--color-black);
                padding: 10px 15px;
                cursor: pointer;
                transition: background-color 0.5s ease-in-out;
            }

            .action {
                display: flex;
                gap: 5px;
            }

            .edit {
                background-color: #198754;

            }

            .edit:hover {
                background-color: #1dc376;
            }

            .delete {
                background-color: #dc3545;

            }

            .edit a,
            .delete a {
                text-decoration: none;
                text-transform: capitalize;
                color: var(--color-black);
            }

            .delete:hover {
                background-color: #e84958;
            }

            .pagination {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 20px;
            }

            .arrowLeft,
            .arrowRight,
            .numPages {

                border: 2px solid var(--color-black);
                padding: 5%;
                color: var(--color-black);
                cursor: pointer;
                transition: all 1s ease-in-out;
            }

            .arrowLeft:hover,
            .arrowRight:hover,
            .numPages:hover {
                background-color: var(--color-box);
                background-color: var(--color-black);
                color: var(--color-second);
            }

            /* media query */
            @media (max-width: 768px) {
                .content {
                    max-width: 100%;
                }



                .content table th,
                .content table td {
                    word-break: break-word;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                }
            }

            @media (max-width:508px) {
                section {
                    margin-top: 20px;
                    width: 100%;
                    padding: 2%;
                }

                section h1 {
                    font-size: 18px;
                }

                .add__booking {
                    right: 10px;
                    top: 40px;
                }

            }
        </style>
    </head>

    <body>
        <?php include('header.php'); ?>
        <section>

            <h1>Welcome : <?php echo $_SESSION['fullname']; ?> </h1>
            <button type="submit" class="add__booking" onclick="location.href='add-booking.php'">Add Booking</button>
            <div class="content">
                <table>
                    <thead>
                        <tr>
                            <th>ID Booking</th>
                            <th>Service</th>
                            <th>Type Of Service</th>
                            <th>Number Phone</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Hours</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {

                        ?>
                                <tr>
                                    <td><?= $row["id_booking"] ?></td>


                                    <td><?= $row["service"] ?></td>
                                    <?php if ($row['typeOfService'] == 'yes') {
                                        echo "<td> <p style='color:#198754;'> With Machine Robots </p> </td>";
                                    } else {
                                        echo "<td> <p style='color:#dc3545;'> Without Machine Robots </p> </td>";
                                    } ?>
                                    <td><?= "0" . $row["numberPhone"] ?></td>
                                    <td><?= $row["address"] ?></td>
                                    <td><?= $row["date"] ?></td>
                                    <td><?= $row["time"] ?></td>

                                    <?php
                                    if ($row['status'] == "accept") {
                                        echo "<td style='color:#198754;'>" . $row['status'] . "</td>";
                                    } else {
                                        echo "<td style='color:red;'>" . $row['status'] . "</td>";
                                    }
                                    ?>
                                    <td class='action'>
                                        <a class='edit' href='update_booking.php?id=<?= $row['id_booking']; ?>'><i class="fas fa-edit"></i></a>
                                        <a class='delete' href='delete_booking.php?id=<?= $row['id_booking']; ?>'><i class="fa-solid fa-trash-can"></i></a>
                                    </td>

                                </tr>
                        <?php }
                        } else {
                            echo "<tr><td colspan='12' style='width:100%;text-align:center;padding:3%;font-size: clamp(11px, 2vw, 15px);'>No! Record Found</td></tr>";
                        }  ?>



                    </tbody>
                </table>
            </div>
            <div class="pagination">
            <?php if ($page > 1) {
                echo "<a href='booking.php?page_number=" . ($page - 1) . "' class='arrowLeft'><i class='fa-solid fa-chevron-left'></i></a>";
            } ?>




            <?php

            for ($i = 1; $i < $total_pages; $i++) {
                echo '<a href="booking.php?page_number=' . $i . '" class="numPages">' . $i . '</a>';
            }
            ?>

            <?php if ($page < $total_pages) {
                echo "<a href='booking.php?page_number=" . ($page + 1) . "' class='arrowRight'><i class='fa-solid fa-chevron-right'></i></a>";
            } ?>


        </div>
        </section>
    </body>

    </html>
<?php } ?>