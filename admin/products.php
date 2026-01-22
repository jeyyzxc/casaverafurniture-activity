<?php 
$activePage = 'products';
$pageCss = 'products.css';
$pageJs = 'products.js';
include 'includes/admin-header.php'; 
?>

<div class="page-header">
    <h1>Product Management</h1>
    <button class="btn-primary" onclick="openProductModal()">+ Add New Product</button>
</div>

<div class="card filter-bar">
    <form class="filter-grid">
        <input type="text" placeholder="Search by Name or SKU...">
        <select>
            <option value="">All Categories</option>
            <option value="living-room">Living Room</option>
        </select>
        <select>
            <option value="">Status</option>
            <option value="in-stock">In Stock</option>
            <option value="low-stock">Low Stock</option>
        </select>
        <button type="submit" class="btn-secondary">Filter</button>
    </form>
</div>

<div class="card">
    <table class="data-table">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th>
                <th>Image</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="checkbox"></td>
                <td><div class="img-thumb"></div></td>
                <td>Velvet Sofa</td>
                <td>VS-001</td>
                <td>$899.00</td>
                <td><span class="badge warning">5 Left</span></td>
                <td><span class="status active">Active</span></td>
                <td>
                    <button class="action-btn edit"><i class="fas fa-edit"></i></button>
                    <button class="action-btn delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Add Product</h2>
        <form id="productForm">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="sku">
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" step="0.01">
                </div>
            </div>
            <div class="form-group">
                <label>Images</label>
                <div class="image-uploader" id="imageDropZone">
                    <p>Drag & Drop images here</p>
                </div>
            </div>
            <button type="submit" class="btn-primary">Save Product</button>
        </form>
    </div>
</div>

<?php include 'includes/admin-footer.php'; ?>