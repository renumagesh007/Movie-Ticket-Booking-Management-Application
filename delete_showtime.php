<?php
require_once "../config.php";
if (!isAdmin()) { redirect("../login.php"); }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("DELETE FROM showtimes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
redirect("showtimes.php");
?>
