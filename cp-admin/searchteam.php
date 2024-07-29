<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../cp-team/login.php");
    exit();
} else {
    if (isset($_POST['search'])) {
        $searchTerm = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['search']))));

        $sql = "SELECT * FROM workers WHERE fullname LIKE '%$searchTerm%' OR city LIKE '%$searchTerm%' OR numberPhone LIKE '%$searchTerm%'";
        $query = mysqli_query($conn, $sql);
        $data = ''; ?>
        <thead>
            <tr>
                <th>Type</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Number Phone</th>
                <th>Address</th>
                <th>City</th>
                <th>Position</th>
                <th>Work Day</th>
                <th>Date Register</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
        </thead>
<?php if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data .= '<tr class="trow">';
                $data .= '<td>' . $row['type'] . '</td>';
                $data .= '<td>' . $row['username'] . '</td>';
                $data .= '<td>' . $row['fullname'] . '</td>';
                $data .= '<td>' . $row['email'] . '</td>';
                $data .= '<td>' . "0" . $row['numberPhone'] . '</td>';
                $data .= '<td>' . $row['address'] . '</td>';
                $data .= '<td>' . $row['city'] . '</td>';
                $data .= '<td>' . $row['position'] . '</td>';
                $data .= '<td>' . $row['workDays'] . '</td>';
                $data .= '<td>' . $row['DateRegister'] . '</td>';
                if ($row['status'] == "accept") {
                    $data .= '<td style="color:#198754;">' . $row['status'] . '</td>';
                } else {
                    $data .= '<td style="color:red;">' . $row['status'] . '</td>';
                }
                $data .= '<td class="action">';
                $data .= '<a class="edit" href="edit__user.php?id=' . $row['idWorker'] . '"><i class="fa-solid fa-edit"></i></a> &nbsp';
                $data .= '<a class="delete" href="delete__user.php?id=' . $row['idWorker'] . '"><i class="fa-solid fa-trash-can"></i></a>';
                $data .= '</td>';
                $data .= '</tr>';
            }
        } else {
            $data .= '<tr><td colspan="12" style="width:100%;text-align:center;padding:3%;font-size: clamp(11px, 2vw, 15px);">No Record Found</td></tr>';
        }

        echo $data;
        exit(); // Exit after sending the search results
    }
}
?>