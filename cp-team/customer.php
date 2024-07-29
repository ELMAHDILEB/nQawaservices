<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'worker') {

    header("Location: ../cp-team/login.php");
    exit();
} else {



    $num_per_page = 15;
    $page = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1;
    $start_from = max(0, ($page - 1) * $num_per_page);


    $query = "SELECT * FROM register LIMIT $start_from, $num_per_page";
    $result = mysqli_query($conn, $query);


    $total_records_query = "SELECT COUNT(*) AS total FROM register";
    $total_records_result = mysqli_query($conn, $total_records_query);
    $total_records = mysqli_fetch_assoc($total_records_result)['total'];
    $total_pages = ceil($total_records / $num_per_page);













?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <style>
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

            .container {
                width: 100%;
                height: 100%;
                margin: 0 auto;
                padding: 2%;
                display: flex;
                flex-direction: column;
                justify-content: start;
                align-items: center;
                gap: 20px;
            }

            .inputSearch {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                position: relative;
            }

            .inputSearch input {
                width: 300px;
                padding: 5px 14px;
                border: none;
                outline: none;
                border-radius: 25px;
                transition: all 0.5s ease-in-out;
                text-align: center;
            }

            .inputSearch input:focus {
                box-shadow: 0px 0px 2px 3px rgb(0, 0, 0, 10%);
            }



            .action {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                gap: 10px;
            }

            .add,
            .edit,
            .delete {
                font-size: clamp(11px, 3vw, 15px);
                text-decoration: none;
                font-weight: bold;
                border: none;
                border-radius: 5px;
                outline: none;
                color: #202020;
                padding: 10px 15px;
                cursor: pointer;
                transition: background-color 0.5s ease-in-out;
            }

            .add {
                background-color: #2ebbd4;
            }

            .add:hover {
                background-color: #75d2e3;
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

            .delete:hover {
                background-color: #e84958;
            }

            .table {
                width: 100%;
                max-height: calc(100% - 1.6rem);
                overflow: overlay;
                background-color: var(--color-box);
                margin-top: 30px;
            }

            .table table {
                border-collapse: collapse;
                /* border-spacing: 0; */
                width: 100%;
                display: table;
                border: 1px solid #ccc;
                font-size: 13px;

            }

            .table table thead {
                background: var(--color-box);

            }

            .table table thead tr th {
                color: var(--color-black);
                white-space: pre;
            }

            th {
                padding: 10px;
                color: black;
                word-break: break-word;
                white-space: break-spaces;
            }

            th,
            td {
                text-align: start;
                border-right: 1px solid #ddd;
                border-bottom: 1px solid #ddd;
            }

            td {
                padding: 8px;
                color: var(--color-black);
                background-color: var(--color-second);
            }


            .trow td {
                text-transform: uppercase;
                white-space: pre;
            }

            .trow td:nth-child(8) {
                white-space: pre-line;
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
                padding: 3px 10px;
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



            @media screen and (max-width:1200px) {
                .container {
                    width: 90%;
                }

                .table table th,
                .table table td {
                    word-break: break-word;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                    overflow: hidden;
                }
            }

            @media screen and (max-width:1300px) {
                .trow td:nth-child(8) {
                    white-space: pre;
                }
            }

            @media screen and (max-width: 768px) {
                .container {
                    width: 100%;
                }

                .table table {
                    max-width: 100%;
                    width: 100%;

                }
            }

            @media (max-width:432px) {
                .inputSearch input {
                    width: 200px;
                }
            }
        </style>
        <title>Team</title>
    </head>

    <body>

        <div class="container">
            <div class="inputSearch">
                <!-- <a href="index.php?page=search"><i class="fa-solid fa-search"></i></a> -->
                <input type="search" name="search" class="search" placeholder="Search..." id="getValue" />

            </div>
            <div class="action">
                <!-- <a href="index.php?page=add__customer" class="add">Add New Customer</a> -->
            </div>
            <div class="table">
                <table id="showdataCustomer">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>



                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {



                        ?>
                                <tr class='trow'>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['type'] ?></td>
                                    <td><?= $row['username'] ?></td>
                                    <td><?= $row['fullname'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td class='action'>
                                    <a class='edit' href='edit__customer.php?id=<?= $row['id']; ?>'><i class="fas fa-edit"></i></a>
                                    <a class='delete' href='delete__customer.php?id=<?= $row['id']; ?>'><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                                </tr>
                        <?php

                            }
                        } else {
                            echo "<tr><td colspan='12' style='width:100%;text-align:center;padding:3%;font-size: clamp(11px, 2vw, 15px);'>No! Record Found</td></tr>";
                        }
                        ?>


                    </tbody>
                </table>


                <div class="pagination">
                    <?php if ($page > 1) {
                        echo "<a href='index.php?page=customer&page_number=" . ($page - 1) . "' class='arrowLeft'><i class='fa-solid fa-chevron-left'></i></a>";
                    } ?>




                    <?php

                    for ($i = 1; $i < $total_pages; $i++) {
                        echo '<a href="index.php?page=customer&page_number=' . $i . '" class="numPages">' . $i . '</a>';
                    }
                    ?>

                    <?php if ($page < $total_pages) {
                        echo "<a href='index.php?page=customer&page_number=" . ($page + 1) . "' class='arrowRight'><i class='fa-solid fa-chevron-right'></i></a>";
                    } ?>


                </div>

            </div>


        </div>
        <script src="../JS/ajax.js"></script>

    </body>

    </html>
<?php }
//! Close the database connection
mysqli_close($conn);

?>