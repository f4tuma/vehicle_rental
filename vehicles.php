<?php
require_once 'includes/db.php';

// Process Form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vehicle'])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $rate = $_POST['daily_rate'];

    $stmt = $pdo->prepare("INSERT INTO vehicles (make, model, year, daily_rate) VALUES (?, ?, ?, ?)");
    $stmt->execute([$make, $model, $year, $rate]);
    header("Location: vehicles.php");
    exit;
}

// Fetch all vehicles
$vehicles = $pdo->query("SELECT * FROM vehicles")->fetchAll();
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-4">
            <h4 class="mb-3">Add Fleet Vehicle</h4>
            <form action="vehicles.php" method="POST" id="vehicleForm">
                <div class="mb-3">
                    <label class="form-label">Make</label>
                    <input type="text" name="make" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Model</label>
                    <input type="text" name="model" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Year</label>
                    <input type="number" name="year" min="1900" max="2027" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Daily Rate ($)</label>
                    <input type="number" step="0.01" name="daily_rate" class="form-control" required>
                </div>
                <button type="submit" name="add_vehicle" class="btn btn-primary w-100">Register Vehicle</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm p-4 table-responsive">
            <h4 class="mb-3">Current Inventory</h4>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th><th>Vehicle</th><th>Year</th><th>Rate</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vehicles as $v): ?>
                    <tr>
                        <td><?= $v['id'] ?></td>
                        <td><strong><?= htmlspecialchars($v['make'] . ' ' . $v['model']) ?></strong></td>
                        <td><?= $v['year'] ?></td>
                        <td>$<?= number_format($v['daily_rate'], 2) ?></td>
                        <td>
                            <span class="badge bg-<?= $v['status'] == 'Available' ? 'success' : 'danger' ?>">
                                <?= $v['status'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>