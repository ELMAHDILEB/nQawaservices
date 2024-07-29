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

        $sql =  "SELECT booking.id_booking, register.fullname, booking.service, booking.typeOfService, booking.numberPhone, booking.address, booking.date, booking.time, booking.status
        FROM booking
        INNER JOIN register ON booking.idUser = register.id 
        WHERE register.fullname LIKE '%$searchTerm%' 
            OR booking.service LIKE '%$searchTerm%'
            OR booking.typeOfService LIKE '%$searchTerm%' 
            OR booking.numberPhone LIKE '%$searchTerm%' 
            OR booking.address LIKE '%$searchTerm%'
            OR booking.date LIKE '%$searchTerm%'
            OR booking.status LIKE '%$searchTerm%'";
        $query = mysqli_query($conn, $sql); // Execute the SQL query


        $data = ''; ?>
        <thead>
            <tr>
                <th>ID Booking</th>
                <th>Full Name</th>
                <th>Service</th>
                <th>Type Of Service</th>
                <th>Number Phone</th>
                <th>Address</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>


            </tr>
        </thead>
<?php if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data .= '<tr class="trow">';
                $data .= '<td>' . $row['id_booking'] . '</td>';
                $data .= '<td>' . $row['fullname'] . '</td>';
                $data .= '<td>' . $row['service'] . '</td>';
                $data .= ($row['typeOfService'] == 'yes') ? "<td> <p style='color:#198754;'> With Machine Robots </p> </td>" : "<td> <p style='color:#dc3545;'> Without Machine Robots </p> </td>";
                $data .= '<td>' . "0" . $row['numberPhone'] . '</td>';
                $data .= '<td>' . $row['address'] . '</td>';
                $data .= '<td>' . $row['date'] . '</td>';

                if ($row['status'] == "accept") {
                    $data .= '<td style="color:#198754;">' . $row['status'] . '</td>';
                } else {
                    $data .= '<td style="color:red;">' . $row['status'] . '</td>';
                }
                $data .= '<td class="action">';
                $data .= '<a class="edit" href="edit__booking.php?id=' . $row['id_booking'] . '"><i class="fas fa-edit"></i></a>';
                $data .= '<a class="delete" href="delete__booking.php?id=' . $row['id_booking'] . '"><i class="fa-solid fa-trash-can"></i></a>';
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