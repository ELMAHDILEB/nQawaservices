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
        $idMessage = mysqli_real_escape_string($conn, $_GET['id']);
        
        // Delete from the second table first to avoid foreign key constraint issues
        $queryWriteusTable = "DELETE FROM writeus WHERE id_message = '$idMessage'";
        $runQueryWriteusTable = mysqli_query($conn, $queryWriteusTable);

     

        if (!$runQueryWriteusTable) {
            echo "Failed Query: " . mysqli_error($conn);
        } else {
            echo "<script>alert('Delete Message Successfully')window.location = 'index.php?page=messages;</script>";
    
            exit();
        }
    } else {
        echo "<script>alert('Message Id Is Not Provided');</script>";
        exit();
    }
}

// Close the database connection
mysqli_close($conn);
?>
