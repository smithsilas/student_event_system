<?php
/**
 * Database connection
 * Uses MySQLi (procedural-friendly, matches the rest of the codebase).
 * Update the credentials below to match your local / server MySQL setup.
 */

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "student_registration";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
