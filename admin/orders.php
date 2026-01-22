<?php 
// /admin/orders.php

$activePage = 'orders';
$pageCss = 'orders.css';
$pageJs = 'orders.js';
include 'includes/admin-header.php'; 
?>

<div class="page-header">
    <h1>Order Management</h1>
    <div class="header-actions">
        <button class="btn-secondary" onclick="window.print()"><i class="fas fa-print"></i> Print Report</button>
        <button class="btn-primary"><i class="fas fa-file-export"></i> Export CSV</button>
    </div>
</div>

<div class="card filter-bar">
    <form class="filter-grid-4"> <input type="text" placeholder="Search Order ID or Customer...">
        <select name="status">
            <option value="">All Statuses</option>
            <option value="pending">Pending Payment</option>
            <option value="processing">Processing</option>
            <option value="shipped">Shipped</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <input type="date" placeholder="Start Date">
        <input type="date" placeholder="End Date">
    </form>
</div>

<div class="card">
    <table class="data-table orders-table">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th>Order ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Fulfillment</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr data-order-id="1001">
                <td><input type="checkbox"></td>
                <td class="font-bold">#ORD-1001</td>
                <td>Oct 24, 2023</td>
                <td>
                    <div class="user-cell">
                        <div class="avatar">JM</div>
                        <span>John Mayer</span>
                    </div>
                </td>
                <td class="font-bold">$1,250.00</td>
                <td><span class="badge success">Paid</span></td>
                <td>
                    <select class="status-select pending" onchange="updateStatus(this)">
                        <option value="pending" selected>Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                    </select>
                </td>
                <td>
                    <button class="action-btn view" onclick="openOrderModal('1001')"><i class="fas fa-eye"></i></button>
                </td>
            </tr>

            <tr data-order-id="1002">
                <td><input type="checkbox"></td>
                <td class="font-bold">#ORD-1002</td>
                <td>Oct 23, 2023</td>
                <td>
                    <div class="user-cell">
                        <div class="avatar">AS</div>
                        <span>Arya Stark</span>
                    </div>
                </td>
                <td class="font-bold">$450.00</td>
                <td><span class="badge success">Paid</span></td>
                <td>
                    <select class="status-select shipped" onchange="updateStatus(this)">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped" selected>Shipped</option>
                        <option value="completed">Completed</option>
                    </select>
                </td>
                <td>
                    <button class="action-btn view" onclick="openOrderModal('1002')"><i class="fas fa-eye"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div id="orderModal" class="modal large-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Order Details <span id="modalOrderId">#ORD-1001</span></h2>
            <span class="close-modal">&times;</span>
        </div>
        
        <div class="modal-body">
            <div class="order-info-grid">
                <div class="info-group">
                    <h3>Customer Info</h3>
                    <p><strong>Name:</strong> John Mayer</p>
                    <p><strong>Email:</strong> john@example.com</p>
                    <p><strong>Phone:</strong> +1 555 0199</p>
                </div>
                <div class="info-group">
                    <h3>Shipping Address</h3>
                    <p>123 Gravity Lane<br>Beverly Hills, CA 90210<br>United States</p>
                </div>
                <div class="info-group">
                    <h3>Order Summary</h3>
                    <p><strong>Date:</strong> Oct 24, 2023</p>
                    <p><strong>Status:</strong> <span class="badge warning">Pending</span></p>
                    <p><strong>Payment:</strong> Stripe (**** 4242)</p>
                </div>
            </div>

            <hr class="divider">

            <h3>Items Ordered</h3>
            <table class="simple-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="product-mini">
                                <img src="placeholder.jpg" alt="">
                                <span>Modern Leather Sofa</span>
                            </div>
                        </td>
                        <td>SOFA-001</td>
                        <td>$1,200.00</td>
                        <td>1</td>
                        <td>$1,200.00</td>
                    </tr>
                    <tr>
                        <td>Shipping (Standard)</td>
                        <td>-</td>
                        <td>$50.00</td>
                        <td>1</td>
                        <td>$50.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                        <td class="text-bold">$1,250.00</td>
                    </tr>
                </tfoot>
            </table>

            <div class="order-notes">
                <h3>Order History / Notes</h3>
                <textarea placeholder="Add a private note for staff..."></textarea>
                <button class="btn-small btn-secondary">Add Note</button>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-secondary" onclick="printPackingSlip()">Print Packing Slip</button>
            <button class="btn-primary">Update Order</button>
        </div>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>