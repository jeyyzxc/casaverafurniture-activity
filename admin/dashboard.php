<?php 
// /admin/dashboard.php

// 1. Integration Layer (Mock Data for now)
// REPLACE these with SQL COUNT/SUM queries later
$totalProducts = 124;
$pendingOrders = 8;
$totalCustomers = 840;
$monthlyRevenue = 45200.00;

// Page Setup
$activePage = 'dashboard';
$pageCss = 'dashboard.css'; // Specific styles for grid/charts
$pageJs = 'dashboard.js';   // Chart.js initialization
include 'includes/admin-header.php'; 
?>

<div class="page-header">
    <h1>Dashboard</h1>
    <div class="date-filter">
        <span>Last 30 Days</span>
        <button class="btn-icon"><i class="fas fa-calendar-alt"></i></button>
    </div>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-info">
            <span class="metric-label">Total Revenue</span>
            <span class="metric-value">$<?php echo number_format($monthlyRevenue, 2); ?></span>
            <span class="metric-trend positive">
                <i class="fas fa-arrow-up"></i> 12% vs last month
            </span>
        </div>
        <div class="metric-icon icon-revenue">
            <i class="fas fa-dollar-sign"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <span class="metric-label">Pending Orders</span>
            <span class="metric-value"><?php echo $pendingOrders; ?></span>
            <span class="metric-trend warning">
                <i class="fas fa-exclamation-circle"></i> Needs Attention
            </span>
        </div>
        <div class="metric-icon icon-orders">
            <i class="fas fa-shopping-bag"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <span class="metric-label">Total Customers</span>
            <span class="metric-value"><?php echo $totalCustomers; ?></span>
            <span class="metric-trend positive">
                <i class="fas fa-arrow-up"></i> 5 New today
            </span>
        </div>
        <div class="metric-icon icon-customers">
            <i class="fas fa-users"></i>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-info">
            <span class="metric-label">Total Products</span>
            <span class="metric-value"><?php echo $totalProducts; ?></span>
        </div>
        <div class="metric-icon icon-products">
            <i class="fas fa-box-open"></i>
        </div>
    </div>
</div>

<div class="dashboard-split">
    
    <div class="card chart-container">
        <div class="card-header">
            <h3>Sales Overview</h3>
            <div class="chart-actions">
                <button class="active">Weekly</button>
                <button>Monthly</button>
            </div>
        </div>
        <div class="canvas-wrapper">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <div class="card recent-activity">
        <h3>Recent Activity</h3>
        <ul class="activity-list">
            <li class="activity-item">
                <div class="icon green"><i class="fas fa-check"></i></div>
                <div class="details">
                    <span class="text">Order #1024 completed</span>
                    <span class="time">2 mins ago</span>
                </div>
            </li>
            <li class="activity-item">
                <div class="icon yellow"><i class="fas fa-user-plus"></i></div>
                <div class="details">
                    <span class="text">New Customer: Sarah J.</span>
                    <span class="time">15 mins ago</span>
                </div>
            </li>
            <li class="activity-item">
                <div class="icon red"><i class="fas fa-exclamation-triangle"></i></div>
                <div class="details">
                    <span class="text">Low Stock: Velvet Sofa</span>
                    <span class="time">1 hour ago</span>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Recent Orders</h3>
        <a href="orders.php" class="btn-link">View All</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>#ORD-492</td>
                <td>Michael Scott</td>
                <td><span class="status warning">Pending</span></td>
                <td>$120.50</td>
            </tr>
            <tr>
                <td>#ORD-491</td>
                <td>Pam Beesly</td>
                <td><span class="status success">Completed</span></td>
                <td>$45.00</td>
            </tr>
        </tbody>
    </table>
</div>

<?php include 'includes/admin-footer.php'; ?>