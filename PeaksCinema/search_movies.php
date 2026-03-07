<?php
include_once "peakscinemas_database.php";
session_start();

header('Content-Type: application/json');

if (!isset($_GET['ajax_search']) || trim($_GET['ajax_search']) === '') {
    echo json_encode([]);
    exit;
}

$search = trim($_GET['ajax_search']);
$term = "%{$search}%";

$stmt = $conn->prepare("SELECT Movie_ID, MovieName, MoviePoster FROM movie WHERE MovieName LIKE ? ORDER BY MovieName ASC LIMIT 10");

if ($stmt === false) {
    echo json_encode([]);
    exit;
}

$stmt->bind_param("s", $term);
$stmt->execute();
$result = $stmt->get_result();

$movies = [];
while ($row = $result->fetch_assoc()) {
    $movies[] = $row;
}

echo json_encode($movies);
exit;
