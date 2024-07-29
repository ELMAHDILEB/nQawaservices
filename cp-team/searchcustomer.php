<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'worker') {

    header("Location: ../cp-team/login.php");
    exit();
}  else {
    if (isset($_POST['search'])) {
        $searchTerm = htmlentities(trim(stripslashes(mysqli_real_escape_string($conn, $_POST['search']))));

        $sql = "SELECT * FROM register WHERE username LIKE '%$searchTerm%' OR fullname LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'";
        $query = mysqli_query($conn, $sql);
        $data = ''; ?>
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
<?php if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data .= '<tr class="trow">';
                $data .= '<td>' . $row['id'] . '</td>';
                $data .= '<td>' . $row['type'] . '</td>';
                $data .= '<td>' . $row['username'] . '</td>';
                $data .= '<td>' . $row['fullname'] . '</td>';
                $data .= '<td>' . $row['email'] . '</td>';
                $data .= '<td class="action">';
                $data .= '<a class="edit" href="edit__customer.php?id=' . $row['id'] . '"><i class="fas fa-edit"></i></a>';
                $data .= '<a class="delete" href="delete__customer.php?id=' . $row['id'] . '"><i class="fa-solid fa-trash-can"></i></a>';
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