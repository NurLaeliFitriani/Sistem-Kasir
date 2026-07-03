<?php
session_start();

/* HAPUS SEMUA SESSION */
session_unset();
session_destroy();

/* REDIRECT */
header("Location: login.php");
exit;
?>