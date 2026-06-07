<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch quick statistics
$v_count = $pdo->query("SELECT COUNT(*) FROM vehicles")->fetchColumn();
$c_count = $pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$r_count = $pdo->query("SELECT COUNT(*) FROM rentals")->fetchColumn();
?>

<div class="row my-4">
    <div class="col-md-12 mb-4">
        <h1 class="fw-bold text-dark dashboard-title">Fleet Management Dashboard</h1>
        <p class="text-secondary subtitle-text">Welcome back. Here is your operational overview.</p>
    </div>
</div>

<div class="row text-center justify-content-center">
    <div class="col-md-4 mb-4">
        <div class="card custom-cube-card h-100 shadow-sm border-0 py-4 px-3">
            <div class="card-body d-flex flex-column align-items-center">
                <div class="icon-bubble mb-3 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-car text-primary fs-3"></i>
                </div>
                <h3 class="card-title text-muted fw-normal h5">Total Fleet</h3>
                <p class="metric-number my-2 fw-bold"><?= $v_count ?></p>
                <a href="vehicles.php" class="btn custom-blue-btn w-100 mt-auto py-2 fw-medium">Manage Cars</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card custom-cube-card h-100 shadow-sm border-0 py-4 px-3">
            <div class="card-body d-flex flex-column align-items-center">
                <div class="icon-bubble mb-3 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-users text-primary fs-3"></i>
                </div>
                <h3 class="card-title text-muted fw-normal h5">Registered Customers</h3>
                <p class="metric-number my-2 fw-bold"><?= $c_count ?></p>
                <a href="customers.php" class="btn custom-blue-btn w-100 mt-auto py-2 fw-medium">Manage Clients</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card custom-cube-card h-100 shadow-sm border-0 py-4 px-3">
            <div class="card-body d-flex flex-column align-items-center">
                <div class="icon-bubble mb-3 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-key text-primary fs-3"></i>
                </div>
                <h3 class="card-title text-muted fw-normal h5">Active Rentals</h3>
                <p class="metric-number my-2 fw-bold"><?= $r_count ?></p>
                <a href="rentals.php" class="btn custom-blue-btn w-100 mt-auto py-2 fw-medium">Bookings Center</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>