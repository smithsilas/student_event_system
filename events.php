<?php
$page_title = "Events";
require_once 'includes/db.php';
require_once 'includes/header.php';

$sql = "SELECT * FROM events ORDER BY event_date ASC";
$result = mysqli_query($conn, $sql);
?>

<section class="section">
    <div class="container">
        <h1 class="mb-2">Upcoming Events</h1>
        <p class="text-muted mb-4">Pick an event and register &mdash; it only takes a minute.</p>

        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4">
                        <div class="event-card">
                            <div class="event-img"><?php echo htmlspecialchars($row['event_name']); ?></div>
                            <div class="card-body">
                                <span class="event-date-badge"><?php echo date("d M Y", strtotime($row['event_date'])); ?></span>
                                <h5 class="mt-3 mb-1"><?php echo htmlspecialchars($row['event_name']); ?></h5>
                                <p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['event_venue']); ?></p>
                                <p class="small mb-3"><?php echo htmlspecialchars($row['event_description']); ?></p>
                                <a href="register.php?event_id=<?php echo $row['event_id']; ?>" class="btn btn-primary btn-sm">Register Now</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No events have been added yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
