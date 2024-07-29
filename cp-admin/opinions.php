<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {

    header("Location: ../cp-team/login.php");
    exit();
} else {


    $num_per_page =15;
    $page = isset($_GET['page_number']) ? intval($_GET['page_number']) : 1;
    $start_from = max(0, ($page - 1) * $num_per_page);


    $query = "SELECT * FROM opinions LIMIT $start_from, $num_per_page";
    $result = mysqli_query($conn, $query);


    $total_records_query = "SELECT COUNT(*) AS total FROM opinions";
    $total_records_result = mysqli_query($conn, $total_records_query);
    $total_records = mysqli_fetch_assoc($total_records_result)['total'];
    $total_pages = ceil($total_records / $num_per_page);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Blog Admin</title>
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

        body {
            width: 100%;
            min-height: 100svh;
        }

        .container {
            width: 90%;
            height: 100%;
            margin: 0 auto;
            padding-top: 2%;
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



        .table {
            width: 100%;
            max-height: calc(100% - 1.6rem);
            overflow: overlay;
            background-color: var(--color-box);
            margin-top: 30px;
        }

        .table table :has(th, td) {
            /* font-size: clamp(11px, 2vw, 14px); */
            word-break: break-word;
            white-space: nowrap;
            white-space: -moz-pre-space;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        table {
            width: 100%;
            font-size: clamp(11px, 2vw, 14px);
        }

        .table table thead {
            background: #bbbbbb;
        }

        th {
            padding: 10px;
            color: black;
            text-transform: capitalize;
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

        .picture {
            width: 100px;
            height: 100px;
        }

        .picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border: var(--color-black) solid 3px;
            border-radius: 50%;
        }



        .title {
            font-size: clamp(11px, 2vw, 14px);
        }

        .text__content {
            width: 400px;
            font-size: clamp(11px, 2vw, 14px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }



        .edit,
        .delete {
            font-size: clamp(11px, 2vw, 15px);
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

        @media (max-width:432px) {
            .inputSearch input {
                width: 200px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <form action="" method="GET">
            <div class="inputSearch">
                <!-- <a href="index.php?page=searchBox"><i class="fa-solid fa-search"></i></a> -->
                <input type="search" name="search" class="search" placeholder="Search..." id="getValue" />


            </div>
        </form>

        <div class="table">
            <table id="showdataOpinions">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>picture</th>
                        <th>content</th>
                        <th>status</th>
                        <th>action</th>


                    </tr>
                </thead>
                <tbody>

                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {


                    ?>

                            <tr>
                                <td><?= $row['id_opinion'] ?></td>


                                <td>

                                    <div class="picture">
                                        <img src="../cp-users/pic/<?= $row['picture'] ?>" alt="slider3" loading="lazy" decoding="async" />
                                    </div>

                                </td>
                                <td>
                                    <p class="text__content"><?= $row['content'] ?></p>
                                </td>

                                <?php
                                if ($row['status'] == "accept") {
                                    echo "<td style='color:#198754;'>" . $row['status'] . "</td>";
                                } else {
                                    echo "<td style='color:red;'>" . $row['status'] . "</td>";
                                }
                                ?>
                                <td class='action'>
                                    <a class='edit' href='edit__opinion.php?id=<?= $row['id_opinion']; ?>'><i class="fas fa-edit"></i></a>
                                    <a class='delete' href='delete__opinion.php?id=<?= $row['id_opinion']; ?>'><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                            <tr>
                        <?php
                        }
                    } else {
                        echo "<tr><td colspan='12' style='width:100%;text-align:center;padding:3%;font-size: clamp(11px, 2vw, 15px);'>No! Record Found</td></tr>";
                    }  ?>






                </tbody>
            </table>
        </div>
        <div class="pagination">
            <?php if ($page > 1) {
                echo "<a href='index.php?page=opinions&page_number=" . ($page - 1) . "' class='arrowLeft'><i class='fa-solid fa-chevron-left'></i></a>";
            } ?>




            <?php

            for ($i = 1; $i < $total_pages; $i++) {
                echo '<a href="index.php?page=opinions&page_number=' . $i . '" class="numPages">' . $i . '</a>';
            }
            ?>

            <?php if ($page < $total_pages) {
                echo "<a href='index.php?page=opinions&page_number=" . ($page + 1) . "' class='arrowRight'><i class='fa-solid fa-chevron-right'></i></a>";
            } ?>


        </div>
    </div>
    <script src="../JS/ajax.js"></script>
</body>

</html>
<?php
// Close the database connection
mysqli_close($conn);

?>