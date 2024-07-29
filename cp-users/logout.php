<?php
   require_once('../db/conn.php');
   session_start();
   session_unset();
   session_destroy();
   header("Location: login.php");
   exit();
?>