<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_customer'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $pdo->prepare("INSERT INTO customers (name, email, phone) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $phone]);
    header("Location: customers.php");
    exit;
}

$customers = $pdo->query("SELECT * FROM customers")->fetchAll();
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm p-4">
            <h4 class="mb-3">Register Customer</h4>
            <form action="customers.php" method="POST" id="customerForm">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" required>
                </div>
                <button type="submit" name="add_customer" class="btn btn-success w-100">Save Customer</button>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm p-4 table-responsive">
            <h4 class="mb-3">Customer Directory</h4>
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><strong><?= htmlspecialchars($c['name']) ?></strong></td>
                        <td><?= htmlspecialchars($c['email']) ?></td>
                        <td><?= htmlspecialchars($c['phone']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>