<?php
   require_once('../db/conn.php');
   session_start();
   session_unset();
   session_destroy();
   header('location: ../cp-team/login.php');
   exit();
?>