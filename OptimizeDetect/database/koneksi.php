<?php
// Database Configuration
$host = "localhost";
$user = "root";
$password = "MySQL0606Masum0606";
$db = "mownydb";

// Create Database Connection
$koneksi = mysqli_connect($host, $user, $password, $db);

// Check Connection
if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
