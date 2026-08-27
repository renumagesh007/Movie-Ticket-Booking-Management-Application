<?php
require_once "../config.php";
if (!isAdmin()) { redirect("../login.php"); }

$showtimes = $conn->query("SELECT s.*, m.title FROM showtimes s JOIN movies m ON s.movie_id = m.id ORDER BY s.show_date DESC, s.show_time DESC");

$basePath = "../";
$pageTitle = "Manage Showtimes";
require_once "../includes/header.php";
?>
<h1 class="page-title">Manage Showtimes</h1>
<a href="add_showtime.php" class="btn" style="margin-bottom:18px; display:inline-block;">+ Add New Showtime</a>

<table>
    <tr><th>Movie</th><th>Date</th><th>Time</th><th>Hall</th><th>Total Seats</th><th>Available</th><th>Actions</th></tr>
    <?php while ($s = $showtimes->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($s['title']); ?></td>
            <td><?php echo date("d M Y", strtotime($s['show_date'])); ?></td>
            <td><?php echo date("h:i A", strtotime($s['show_time'])); ?></td>
            <td><?php echo htmlspecialchars($s['hall']); ?></td>
            <td><?php echo $s['total_seats']; ?></td>
            <td><?php echo $s['available_seats']; ?></td>
            <td>
                <a href="delete_showtime.php?id=<?php echo $s['id']; ?>" class="btn btn-danger"
                   onclick="return confirm('Delete this showtime and its bookings?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<?php require_once "../includes/footer.php"; ?>
