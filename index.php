<?php
$page_title = "Home";
require_once 'includes/db.php';
require_once 'includes/header.php';

// Pull the next 3 upcoming events for the homepage preview
$sql = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3";
$result = mysqli_query($conn, $sql);
?>

<section class="hero">
    <div class="container">
        <h1>Every college event, one place to register.</h1>
        <p class="lead">Browse what's happening on campus this term and sign up in under a minute &mdash; no queuing at the notice board.</p>
        <a href="events.php" class="btn btn-brass btn-lg">Browse Events</a>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h2>Coming up next</h2>
            <a href="events.php" class="text-decoration-none">See all events &rarr;</a>
        </div>

        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4">
                        <div class="event-card">
                            <div class="event-img"><?php echo htmlspecialchars($row['event_name']); ?></div>
                            <div class="card-body">
                                <span class="event-date-badge"><?php echo date("d M Y", strtotime($row['event_date'])); ?></span>
                                <h5 class="mt-3 mb-1"><?php echo htmlspecialchars($row['event_name']); ?></h5>
                                <p class="text-muted small mb-3"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['event_venue']); ?></p>
                                <a href="register.php?event_id=<?php echo $row['event_id']; ?>" class="btn btn-primary btn-sm">Register</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">No upcoming events right now &mdash; check back soon.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
