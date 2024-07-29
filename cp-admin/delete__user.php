<?php
require_once("../db/conn.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['type']) || $_SESSION['type'] !== 'admin') {
    
    header("Location: ../cp-team/login.php");
    exit();
}else{

    if(isset($_GET['id'])){
       $idWorker = mysqli_real_escape_string($conn,$_GET['id']);
        $query = "DELETE  FROM workers WHERE idWorker = '$idWorker'";
        $runQuery = mysqli_query($conn, $query);
        if(!$runQuery){
             echo "Failed Query" . mysqli_error($conn);
        }else{
            echo "<script>alert('Delete Worker Successfully');</script>";
            sleep(3);
            echo "<script>window.location = 'index.php?page=team'</script>";

        }
    }else{
        echo "<script>alert('Worker Id Is Not Provided');</script>";
    }
    
}
// Close the database connection
mysqli_close($conn);

?>