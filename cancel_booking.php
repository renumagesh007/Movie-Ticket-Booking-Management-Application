<?php
require_once "config.php";
if (!isLoggedIn()) { redirect("login.php"); }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if ($booking && $booking['status'] === 'Confirmed') {
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE showtimes SET available_seats = available_seats + ? WHERE id = ?");
        $stmt->bind_param("ii", $booking['seats_booked'], $booking['showtime_id']);
        $stmt->execute();

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
    }
}

redirect("my_bookings.php?cancelled=1");
?>
