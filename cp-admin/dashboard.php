<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {

    // Query to count the number of bookings
    $countBookingQuery = "SELECT COUNT(*) AS booking_count FROM booking";
    $countBookingResult = mysqli_query($conn, $countBookingQuery);
    $bookingCount = mysqli_fetch_assoc($countBookingResult)['booking_count'];

    // Query to count the number of registrations
    $countRegisterQuery = "SELECT COUNT(*) AS register_count FROM register";
    $countRegisterResult = mysqli_query($conn, $countRegisterQuery);
    $registerCount = mysqli_fetch_assoc($countRegisterResult)['register_count'];

    // Query to count the number of blogs
    $countBlogsQuery = "SELECT COUNT(*) AS blog_count FROM blogs";
    $countBlogsResult = mysqli_query($conn, $countBlogsQuery);
    $blogsCount = mysqli_fetch_assoc($countBlogsResult)['blog_count'];




    $query = "SELECT booking.id_booking, register.fullname, booking.service, booking.date, booking.time, booking.status
FROM booking
INNER JOIN register ON booking.idUser = register.id
ORDER BY register.fullname ASC
LIMIT 10";
    $run = mysqli_query($conn, $query);


    $queryRegister = "SELECT * FROM register ORDER BY  fullname and dateRegister ASC LIMIT 10";
    $runRegister = mysqli_query($conn, $queryRegister);
}
// Close the database connection
mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 100svh;
        }

        main {
            /* background-color: green; */
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: start;
        }

        .container {
            /* background-color: red; */
            width: 80%;
            margin: 0px auto;
            padding: 2% 0;
            color: var(--color-black);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .all__box {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .box {
            background-color: var(--color-hover);
            flex-basis: 250px;
            flex-grow: 1;
            display: flex;
            flex-wrap: wrap;
            justify-content: start;
            align-items: center;
            gap: 10px;
            padding: 3%;
            box-shadow: rgba(60, 64, 67, 0.23) 0px 0.768762px 1.53752px 0px, rgba(60, 64, 67, 0.114) 0px 1.53752px 4.61257px 1.53752px;
        }

        .all__recent {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
            padding-bottom: 3%;
        }



        /* Table */
        .table {
            width: 58%;
            overflow: overlay;
            background-color: var(--color-box);
            margin-top: 30px;
            box-shadow: rgba(60, 64, 67, 0.23) 0px 0.768762px 1.53752px 0px, rgba(60, 64, 67, 0.114) 0px 1.53752px 4.61257px 1.53752px;
        }

        .title__table {
            font-size: clamp(20px, 2vw, 28px);
            text-transform: capitalize;
            color: var(--color-black);
            margin-bottom: 20px;
        }

        .table table :has(th, td) {
            font-size: 15px;
            word-break: break-word;
            white-space: nowrap;
            white-space: -moz-pre-space;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        table {
            width: 100%;
        }

        .table table thead {
            background: #bbbbbb;
        }

        th {
            padding: 10px;
            color: black;
        }

        th,
        td {
            text-align: start;
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 10px;
            color: var(--color-black);
        }

        tr:nth-child(2n) {
            background: var(--color-second);
        }

        .status {
            border: none;
            outline: none;
            padding: 10px 14px;
        }

        .status option {
            text-transform: capitalize;
        }

        .recent__customers {
            display: flex;
            flex-direction: column;
            width: 40%;
            max-height: calc(100% - 1.6rem);
            background-color: var(--color-box);
            margin-top: 30px;
            box-shadow: rgba(60, 64, 67, 0.23) 0px 0.768762px 1.53752px 0px, rgba(60, 64, 67, 0.114) 0px 1.53752px 4.61257px 1.53752px;
        }

        .recent__customers h3 {
            font-size: clamp(20px, 2vw, 28px);
            text-transform: capitalize;
            color: var(--color-black);
            margin-bottom: 20px;
        }

        .customers {
            display: flex;
            margin-top: 9px;
        }

        .customers table thead {
            background-color: #bbbbbb;
        }

        .name,
        .date {
            font-size: 15px;
            text-transform: capitalize;
            color: var(--color-black);
        }



        @media screen and (max-width:1200px) {
            .container {
                width: 90%;
            }

            .box {
                width: 230px;
            }

            .table table th,
            .table table td {
                word-break: break-word;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
            }

        }

        @media (max-width:840px) {
            .table {
                width: 100%
            }

            .recent__customers {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .container {
                width: 100%;
                padding: 2%;
            }

            .table table {
                max-width: 100%;
                width: 100%;

            }


        }


        @media screen and (max-width:670px) {
            .container {
                height: 800px;
            }
        }

        @media screen and (max-width:600px) {

            .openSideBar,
            .closeSideBar {
                left: 37px;
            }

            .box {
                width: 230px;

            }
        }

        @media (max-width:500px) {
            .all__box {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="all__box">
        <div class="box">
                <i class="fa-regular fa-calendar-days"></i>
                <p>Total Booking : </p>
                <h2><?= $bookingCount?></h2>
            </div>
            <div class="box">
                <i class="fa-solid fa-user"></i>
                <p>Total Users : </p>
                <h2><?= $registerCount?></h2>
            </div>
            <div class="box">
                <i class="fa-solid fa-square-rss"></i>
                <p>Total Blogs : </p>
                <h2><?=$blogsCount?></h2>
            </div>
            
        </div>

        <div class="all__recent">

<div class="table">
    <div class="title__table">
        <h3>recent booking</h3>
    </div>
    <table>
        <thead>
            <tr>

                <th>Full Name</th>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>


            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($run) > 0) {
                while ($row = mysqli_fetch_assoc($run)) {
            ?>
                    <tr>
                        <td><?= $row["fullname"] ?></td>
                        <td><?= $row["service"] ?></td>
                        <td><?= $row["date"] ?></td>
                        <td><?= $row["time"] ?></td>
                        <?php
                        if ($row['status'] == "accept") {
                            echo "<td style='color:#198754;'>" . $row['status'] . "</td>";
                        } else {
                            echo "<td style='color:red;'>" . $row['status'] . "</td>";
                        }
                        ?>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='12' style='width:100%;text-align:center;padding:3%;font-size: clamp(11px, 2vw, 15px);'>No! Record Found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>


<div class="recent__customers">
    <h3>recent customers</h3>

    <div class="customers">

        <table>
            <thead>
                <tr>
                    <th>
                        Full Name
                    </th>
                    <th>
                        Date
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php


                if (mysqli_num_rows($runRegister) > 0) {
                    while ($rowss = mysqli_fetch_assoc($runRegister)) {

                ?>
                        <tr>
                            <td>
                                <p class="name"><?= $rowss['fullname'] ?></p>
                            </td>
                            <td>
                                <p class="date"><?= $rowss['dateRegister'] ?></p>
                            </td>
                        </tr>
                <?php }
                } else {
                    echo "<tr><td colspan='12' style='width:100%;text-align:center;padding:3%;font-size: clamp(11px, 2vw, 15px);'>No! Record Found</td></tr>";
                }  ?>



            </tbody>
        </table>




    </div>
</div>
        </div>
        <script src="../JS/index.js"></script>

</body>

</html>