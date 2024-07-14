<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'aplikasidatabase2';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Could not connect: ' . $conn->connect_error);
}

// Memulai sesi hanya jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>