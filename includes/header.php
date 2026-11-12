<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Twin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Digital Twin</h1>
    <nav>
        <a href="index.php">Басты бет</a>
        <a href="dashboard.php">Статистика</a>
        <a href="journal.php">Күнделік</a>
    </nav>
</header>
<main>
