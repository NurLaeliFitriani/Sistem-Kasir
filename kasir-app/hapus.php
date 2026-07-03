<?php
require_once 'config.php';

$id = $_GET['id'];

$stmt = mysqli_prepare($conn, "DELETE FROM barang WHERE id_barang=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: index.php");
?>
