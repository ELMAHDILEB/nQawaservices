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

        $sql = "SELECT * FROM opinions WHERE content LIKE '%$searchTerm%' OR status LIKE '%$searchTerm%'";
        $query = mysqli_query($conn, $sql);
        $data = ''; ?>
        <thead>
            <tr>
                <th>#</th>
                <th>picture</th>
                <th>content</th>
                <th>status</th>
                <th>action</th>

            </tr>
        </thead>
<?php if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data .= '<tr class="trow">';
                $data .= '<td>' . $row['id_opinion'] . '</td>';
                $data .= '<td><div class="picture">
                <img srcset="
                ../cp-users/pic/' . $row['picture'] . ' 200w,
                  ../cp-users/pic/' . $row['picture'] . ' 563w,
                  ../cp-users/pic/' . $row['picture'] . ' 834w
                " src="../cp-users/pic/' . $row['picture'] . '" alt="' . $row['title'] . '" loading="lazy" decoding="async" />
              </div></td>';
              $data .= '<td><p class="text__content">' . $row['content'] . '</p></td>';
             
                if ($row['status'] == "accept") {
                    $data .= '<td style="color:#198754;">' . $row['status'] . '</td>';
                } else {
                    $data .= '<td style="color:red;">' . $row['status'] . '</td>';
                }
                $data .= '<td class="action">';
                $data .= '<a class="edit" href="edit__opinion.php?id=' . $row['id_opinion'] . '"><i class="fas fa-edit"></i></a>&nbsp&nbsp';
                $data .= '<a class="delete" href="delete__opinion.php?id=' . $row['id_opinion'] . '"><i class="fa-solid fa-trash-can"></i></a>';
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