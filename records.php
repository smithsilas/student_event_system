<?php
$page_title = "Registrations";
require_once 'includes/db.php';
require_once 'includes/header.php';

$sql = "SELECT r.registration_id, r.student_name, r.admission_number, r.email, r.phone,
               r.course, e.event_name, r.registration_date
        FROM registrations r
        JOIN events e ON r.event_id = e.event_id
        ORDER BY r.registration_date DESC";
$result = mysqli_query($conn, $sql);
$total = mysqli_num_rows($result);
?>

<section class="section">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <h1 class="mb-0">Registrations</h1>
            <span class="stat-pill"><i class="bi bi-people-fill"></i> <span class="count" id="totalCount"><?php echo $total; ?></span>&nbsp;registered</span>
        </div>

        <div class="records-card">
            <div class="row mb-3">
                <div class="col-md-5">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search by name, admission no, event...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="recordsTable">
                    <thead>
                        <tr>
                            <th>Reg ID</th>
                            <th>Name</th>
                            <th>Admission No.</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Event</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td>#<?php echo str_pad($row['registration_id'], 4, "0", STR_PAD_LEFT); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['admission_number']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                                    <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                                    <td><?php echo date("d M Y, g:i a", strtotime($row['registration_date'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center text-muted py-4">No registrations yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <p class="text-muted small mb-0" id="noResultsMsg" style="display:none;">No matching registrations found.</p>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

<script src="js/search.js"></script>
