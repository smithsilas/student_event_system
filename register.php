<?php
$page_title = "Register";
require_once 'includes/db.php';
require_once 'includes/header.php';

$selected_event = isset($_GET['event_id']) ? (int) $_GET['event_id'] : 0;

$events_result = mysqli_query($conn, "SELECT event_id, event_name, event_date FROM events ORDER BY event_date ASC");

// Show a success or error banner if we were redirected back here after submitting
$status = $_GET['status'] ?? '';
?>

<section class="section">
    <div class="container" style="max-width: 640px;">
        <h1 class="mb-4">Event Registration</h1>

        <?php if ($status === 'success'): ?>
            <div class="alert alert-success" id="statusAlert">
                <i class="bi bi-check-circle"></i> You're registered! A confirmation has been recorded.
            </div>
        <?php elseif ($status === 'error'): ?>
            <div class="alert alert-danger" id="statusAlert">
                <i class="bi bi-exclamation-triangle"></i> Something went wrong. Please check your details and try again.
            </div>
        <?php elseif ($status === 'invalid'): ?>
            <div class="alert alert-warning" id="statusAlert">
                <i class="bi bi-exclamation-circle"></i> Please fill in every field correctly before submitting.
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form action="process_registration.php" method="POST" id="registrationForm" class="needs-validation" novalidate>

                <div class="mb-3">
                    <label class="form-label" for="student_name">Full Name</label>
                    <input type="text" class="form-control" id="student_name" name="student_name" required minlength="3">
                    <div class="invalid-feedback">Please enter your full name.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="admission_number">Admission Number</label>
                    <input type="text" class="form-control" id="admission_number" name="admission_number" required>
                    <div class="invalid-feedback">Please enter your admission number.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required pattern="^[0-9+\s-]{7,15}$">
                    <div class="invalid-feedback">Please enter a valid phone number.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="course">Course</label>
                    <input type="text" class="form-control" id="course" name="course" required>
                    <div class="invalid-feedback">Please enter your course.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label" for="event_id">Event</label>
                    <select class="form-select" id="event_id" name="event_id" required>
                        <option value="" disabled <?php echo $selected_event === 0 ? 'selected' : ''; ?>>Choose an event&hellip;</option>
                        <?php while ($ev = mysqli_fetch_assoc($events_result)): ?>
                            <option value="<?php echo $ev['event_id']; ?>" <?php echo $selected_event === (int)$ev['event_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ev['event_name']) . " — " . date("d M Y", strtotime($ev['event_date'])); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <div class="invalid-feedback">Please choose an event.</div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Submit Registration</button>
            </form>
        </div>
    </div>
</section>

<!-- Confirmation modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm your registration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="confirmModalBody">
                Please review your details before submitting.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Go back</button>
                <button type="button" class="btn btn-primary" id="confirmSubmitBtn">Confirm & Submit</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

<script src="js/validation.js"></script>
