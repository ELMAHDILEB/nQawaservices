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

        $sql = "SELECT * FROM blogs WHERE title LIKE '%$searchTerm%' OR content LIKE '%$searchTerm%' OR DateAdd LIKE '%$searchTerm%'";
        $query = mysqli_query($conn, $sql);
        $data = ''; ?>
        <thead>
            <tr>
                <th>#</th>
                <th>writer</th>
                <th>title</th>
                <th>image</th>
                <th>content</th>
                <th>DateAdd</th>
                <th>Action</th>

            </tr>
        </thead>
<?php if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data .= '<tr class="trow">';
                $data .= '<td>' . $row['id_blogs'] . '</td>';
                $data .= '<td>' . $row['writeBy'] . '</td>';
                $data .= '<td><p class="title">' . $row['title'] . '</p></td>';
                $data .= '<td><div class="picture">
                <img srcset="
                ./picBlog/' . $row['image'] . ' 200w,
                ./picBlog/' . $row['image'] . ' 563w,
                ./picBlog/' . $row['image'] . ' 834w
                " src="./picBlog/' . $row['image'] . '" alt="' . $row['title'] . '" loading="lazy" decoding="async" />
              </div></td>';
                $data .= '<td><p class="text__content">' . $row['content'] . '</p></td>';
                $data .= '<td>' . $row['DateAdd'] . '</td>';
                $data .= '<td class="action" >';
                $data .= '<a class="edit" style="margin-right:10px;" href="edit__blog.php?id=' . $row['id_blogs'] . '"><i class="fas fa-edit"></i></a>';
                $data .= '<a class="delete" href="delete__blog.php?id=' . $row['id_blogs'] . '"><i class="fa-solid fa-trash-can"></i></a>';
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