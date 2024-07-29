<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    header("Location: ../cp-team/login.php");
    exit();
} else {
    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        
        
        // Delete from the second table first to avoid foreign key constraint issues
        $queryOpinionsTable = "DELETE FROM opinions WHERE idUser = '$id'";
        $runQueryOpinionsTable = mysqli_query($conn, $queryOpinionsTable);

        // Delete from the register table
        $queryRegisterTable = "DELETE FROM register WHERE id = '$id';";
        $runQueryRegisterTable = mysqli_query($conn, $queryRegisterTable);

        if (!$runQueryOpinionsTable || !$runQueryRegisterTable) {
            echo "Failed Query: " . mysqli_error($conn);
        } else {
            echo "<script>alert('Delete User Successfully');</script>";
            sleep(3);
            echo "<script>window.location = 'index.php?page=customer'</script>";
            exit();
        }
    } else {
        echo "<script>alert('User Id Is Not Provided');</script>";
        exit();
    }
}

// Close the database connection
mysqli_close($conn);
?>
