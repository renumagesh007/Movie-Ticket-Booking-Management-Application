<?php
require_once "../config.php";
if (!isAdmin()) { redirect("../login.php"); }

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $genre = trim($_POST['genre']);
    $language = trim($_POST['language']);
    $duration = (int)$_POST['duration_minutes'];
    $poster_url = trim($_POST['poster_url']);
    $price = (float)$_POST['price'];

    if (empty($title) || empty($genre) || $duration <= 0 || $price <= 0) {
        $error = "Please fill all required fields correctly.";
    } else {
        $stmt = $conn->prepare("INSERT INTO movies (title, description, genre, language, duration_minutes, poster_url, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisd", $title, $description, $genre, $language, $duration, $poster_url, $price);
        if ($stmt->execute()) {
            redirect("movies.php");
        } else {
            $error = "Failed to add movie.";
        }
    }
}

$basePath = "../";
$pageTitle = "Add Movie";
require_once "../includes/header.php";
?>
<div class="form-box">
    <h2>Add New Movie</h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>
    <form method="POST">
        <div class="form-group"><label>Title</label><input type="text" name="title" required></div>
        <div class="form-group"><label>Description</label><textarea name="description" rows="3"></textarea></div>
        <div class="form-group"><label>Genre</label><input type="text" name="genre" required></div>
        <div class="form-group"><label>Language</label><input type="text" name="language" required></div>
        <div class="form-group"><label>Duration (minutes)</label><input type="number" name="duration_minutes" required></div>
        <div class="form-group"><label>Poster URL</label><input type="text" name="poster_url" placeholder="https://..."></div>
        <div class="form-group"><label>Ticket Price (₹)</label><input type="number" step="0.01" name="price" required></div>
        <button type="submit" class="btn btn-full">Add Movie</button>
    </form>
</div>
<?php require_once "../includes/footer.php"; ?>
