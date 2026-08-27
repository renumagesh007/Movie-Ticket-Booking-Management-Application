<?php
require_once "../config.php";
if (!isAdmin()) { redirect("../login.php"); }

$movies = $conn->query("SELECT id, title FROM movies ORDER BY title");
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $movie_id = (int)$_POST['movie_id'];
    $show_date = $_POST['show_date'];
    $show_time = $_POST['show_time'];
    $hall = trim($_POST['hall']);
    $total_seats = (int)$_POST['total_seats'];

    if (!$movie_id || empty($show_date) || empty($show_time) || empty($hall) || $total_seats <= 0) {
        $error = "Please fill all fields correctly.";
    } else {
        $stmt = $conn->prepare("INSERT INTO showtimes (movie_id, show_date, show_time, hall, total_seats, available_seats) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssii", $movie_id, $show_date, $show_time, $hall, $total_seats, $total_seats);
        if ($stmt->execute()) {
            redirect("showtimes.php");
        } else {
            $error = "Failed to add showtime.";
        }
    }
}

$basePath = "../";
$pageTitle = "Add Showtime";
require_once "../includes/header.php";
?>
<div class="form-box">
    <h2>Add New Showtime</h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>Movie</label>
            <select name="movie_id" required>
                <option value="">-- Select Movie --</option>
                <?php while ($m = $movies->fetch_assoc()): ?>
                    <option value="<?php echo $m['id']; ?>"><?php echo htmlspecialchars($m['title']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group"><label>Date</label><input type="date" name="show_date" required></div>
        <div class="form-group"><label>Time</label><input type="time" name="show_time" required></div>
        <div class="form-group"><label>Hall</label><input type="text" name="hall" placeholder="Screen 1" required></div>
        <div class="form-group"><label>Total Seats</label><input type="number" name="total_seats" required></div>
        <button type="submit" class="btn btn-full">Add Showtime</button>
    </form>
</div>
<?php require_once "../includes/footer.php"; ?>
