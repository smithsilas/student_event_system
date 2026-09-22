<?php
require_once 'includes/db.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit;
}

// --- Collect and trim input ---
$student_name     = trim($_POST['student_name'] ?? '');
$admission_number = trim($_POST['admission_number'] ?? '');
$email            = trim($_POST['email'] ?? '');
$phone            = trim($_POST['phone'] ?? '');
$course           = trim($_POST['course'] ?? '');
$event_id         = (int) ($_POST['event_id'] ?? 0);

// --- Server-side validation (never trust the client) ---
$errors = [];

if (strlen($student_name) < 3) {
    $errors[] = "Name must be at least 3 characters.";
}
if (empty($admission_number)) {
    $errors[] = "Admission number is required.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "A valid email address is required.";
}
if (!preg_match('/^[0-9+\s-]{7,15}$/', $phone)) {
    $errors[] = "A valid phone number is required.";
}
if (empty($course)) {
    $errors[] = "Course is required.";
}
if ($event_id <= 0) {
    $errors[] = "Please select an event.";
}

if (!empty($errors)) {
    header("Location: register.php?status=invalid");
    exit;
}

// --- Confirm the event actually exists ---
$check_stmt = mysqli_prepare($conn, "SELECT event_id FROM events WHERE event_id = ?");
mysqli_stmt_bind_param($check_stmt, "i", $event_id);
mysqli_stmt_execute($check_stmt);
mysqli_stmt_store_result($check_stmt);

if (mysqli_stmt_num_rows($check_stmt) === 0) {
    header("Location: register.php?status=invalid");
    exit;
}
mysqli_stmt_close($check_stmt);

// --- Insert using a prepared statement (prevents SQL injection) ---
$sql = "INSERT INTO registrations (student_name, admission_number, email, phone, course, event_id)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssssi", $student_name, $admission_number, $email, $phone, $course, $event_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: register.php?status=success");
} else {
    header("Location: register.php?status=error");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
exit;
