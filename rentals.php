<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_rental'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $customer_id = $_POST['customer_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Complex State Logic: Database Transaction
    $pdo->beginTransaction();
    try {
        // 1. Insert Rental Record
        $stmt = $pdo->prepare("INSERT INTO rentals (vehicle_id, customer_id, start_date, end_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$vehicle_id, $customer_id, $start_date, $end_date]);

        // 2. Change car status dynamically so it cannot be double booked
        $update = $pdo->prepare("UPDATE vehicles SET status = 'Rented' WHERE id = ?");
        $update->execute([$vehicle_id]);

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
    }

    header("Location: rentals.php");
    exit;
}

// Fetch relationships for tables
$rentals = $pdo->query("SELECT rentals.id, vehicles.make, vehicles.model, customers.name, rentals.start_date, rentals.end_date 
                        FROM rentals 
                        JOIN vehicles ON rentals.vehicle_id = vehicles.id 
                        JOIN customers ON rentals.customer_id = customers.id")->fetchAll();

$available_cars = $pdo->query("SELECT * FROM vehicles WHERE status = 'Available'")->fetchAll();
$all_customers = $pdo->query("SELECT * FROM customers")->fetchAll();

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-4">
            <h4 class="mb-3">New Rental Booking</h4>
            <form action="rentals.php" method="POST" id="rentalForm">
                <div class="mb-3">
                    <label class="form-label">Select Available Car</label>
                    <select name="vehicle_id" class="form-select" required>
                        <?php foreach($available_cars as $car): ?>
                            <option value="<?= $car['id'] ?>"><?= "{$car['make']} {$car['model']} (\${$car['daily_rate']}/day)" ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Select Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <?php foreach($all_customers as $cust): ?>
                            <option value="<?= $cust['id'] ?>"><?= htmlspecialchars($cust['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Out Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Return Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                </div>
                <button type="submit" name="book_rental" class="btn btn-warning w-100 fw-bold">Commit Order</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm p-4 table-responsive">
            <h4 class="mb-3">Active Agreements Ledger</h4>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr><th>ID</th><th>Vehicle</th><th>Customer</th><th>Start</th><th>End</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($rentals as $r): ?>
                    <tr>
                        <td><?= $r['id'] ?></td>
                        <td><?= htmlspecialchars($r['make'] . ' ' . $r['model']) ?></td>
                        <td><strong><?= htmlspecialchars($r['name']) ?></strong></td>
                        <td><?= $r['start_date'] ?></td>
                        <td><?= $r['end_date'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>