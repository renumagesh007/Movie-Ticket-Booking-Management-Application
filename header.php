<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($pageTitle) ? $pageTitle . " - CineBook" : "CineBook"; ?></title>
<link rel="stylesheet" href="<?php echo isset($basePath) ? $basePath : ''; ?>css/style.css">
</head>
<body>
<div class="navbar">
    <a href="<?php echo isset($basePath) ? $basePath : ''; ?>index.php" class="brand">🎬 CineBook</a>
    <nav>
        <a href="<?php echo isset($basePath) ? $basePath : ''; ?>index.php">Movies</a>
        <?php if (isLoggedIn()): ?>
            <a href="<?php echo isset($basePath) ? $basePath : ''; ?>my_bookings.php">My Bookings</a>
            <?php if (isAdmin()): ?>
                <a href="<?php echo isset($basePath) ? $basePath : ''; ?>admin/dashboard.php">Admin Panel</a>
            <?php endif; ?>
            <span style="margin-left:20px; color:#9ca0b3; font-size:14px;">Hi, <?php echo htmlspecialchars($_SESSION['name']); ?></span>
            <a href="<?php echo isset($basePath) ? $basePath : ''; ?>logout.php" class="highlight">Logout</a>
        <?php else: ?>
            <a href="<?php echo isset($basePath) ? $basePath : ''; ?>login.php">Login</a>
            <a href="<?php echo isset($basePath) ? $basePath : ''; ?>register.php" class="highlight">Register</a>
        <?php endif; ?>
    </nav>
</div>
<div class="container">
