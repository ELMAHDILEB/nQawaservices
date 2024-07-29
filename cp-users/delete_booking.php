<?php
require('../db/conn.php');
session_start();
if (!isset($_SESSION['idUser'])) {
    header('Location: ./login.php');
    exit();
} else {

    if (isset($_GET['id'])) {
        $id_booking = mysqli_real_escape_string($conn, $_GET['id']);
        $sql = "DELETE FROM booking WHERE id_booking = '$id_booking'";
        $result = mysqli_query($conn, $sql);
    
        if (!$result) {
            echo "Query failed: " . mysqli_error($conn);
        } else {
            echo "<script>alert('You Delete This Booking');</script>";
            echo "<script>window.location = './booking.php';</script>";
        }
    } else {
        echo "Booking ID is not provided.";
        exit();
    }
 }


mysqli_close($conn);
