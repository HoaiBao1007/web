<?php include 'app/views/share/header.php'; ?>

<!-- Thanh Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">HYPER BUY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto align-items-center">
                <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="managementDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cogs me-1"></i> Quản lý
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Quản lý sản phẩm</a></li>
                            <li><a class="dropdown-item" href="#">Danh sách sản phẩm</a></li>
                            <li><a class="dropdown-item" href="/Product/add">Thêm sản phẩm</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-list me-1"></i> Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($categories as $category): ?>
                            <li><a class="dropdown-item" href="#"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-truck me-1"></i> Tra cứu đơn hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Product/cart"><i class="fas fa-shopping-cart me-1"></i> Giỏ hàng</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user me-1"></i>
                        <?php if (SessionHelper::isLoggedIn()): ?>
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                            <span class="user-role"><?php echo SessionHelper::isAdmin() ? 'Admin' : 'User'; ?></span>
                        <?php else: ?>
                            Tài khoản
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if (SessionHelper::isLoggedIn()): ?>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i> Tài khoản</a></li>
                            <li><a class="dropdown-item" href="/Account/logout"><i class="fas fa-sign-out-alt me-2"></i> Đăng Xuất</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="/Account/login"><i class="fas fa-sign-in-alt me-2"></i> Đăng Nhập</a></li>
                            <li><a class="dropdown-item" href="/Account/register"><i class="fas fa-user-plus me-2"></i> Đăng Ký</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Danh sách sản phẩm -->
<div class="container my-5">
    <h1 class="text-center mb-5 display-4 fw-bold text-dark">Danh Sách Sản Phẩm</h1>

    <!-- Form tìm kiếm -->
    <form method="POST" action="/Product/search" class="row g-3 mb-5 justify-content-center">
        <div class="col-md-5">
            <div class="input-group shadow-sm rounded-pill overflow-hidden">
                <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="keyword" class="form-control border-0" placeholder="Nhập tên sản phẩm hoặc mô tả" 
                       value="<?php echo isset($_POST['keyword']) ? htmlspecialchars($_POST['keyword']) : ''; ?>">
            </div>
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select shadow-sm rounded-pill border-0">
                <option value="">Tất cả danh mục</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>" 
                            <?php echo (isset($_POST['category_id']) && $_POST['category_id'] == $category->id) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">Tìm Kiếm</button>
        </div>
    </form>

    <?php if (SessionHelper::isAdmin()): ?>
        <div class="text-end mb-4">
            <a href="/Product/add" class="btn btn-success rounded-pill px-4 shadow-sm"><i class="fas fa-plus me-2"></i>Thêm Sản Phẩm</a>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if (empty($products)): ?>
            <p class="text-center text-muted fs-5">Không tìm thấy sản phẩm nào.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card product-card h-100 border-0 shadow-sm overflow-hidden">
                        <div class="product-img-wrapper">
                            <img src="/<?php echo $product->image ? htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8') : 'images/default-product.jpg'; ?>" 
                                alt="Product Image" class="card-img-top">
                            <div class="product-overlay">
                                <a href="/Product/show/<?php echo $product->id; ?>" class="btn btn-outline-light btn-sm rounded-pill">Xem Chi Tiết</a>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h6 class="card-title mb-2">
                                <a href="/Product/show/<?php echo $product->id; ?>" class="text-dark text-decoration-none fw-semibold">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h6>
                            <p class="text-primary fw-bold mb-1"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</p>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="d-flex justify-content-center gap-2">
                                <?php if (SessionHelper::isAdmin()): ?>
                                    <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-outline-warning btn-sm rounded-pill">✏️</a>
                                    <a href="/Product/delete/<?php echo $product->id; ?>" class="btn btn-outline-danger btn-sm rounded-pill" 
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">🗑️</a>
                                <?php endif; ?>
                                <a href="/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm rounded-pill px-3">Thêm Vào Giỏ</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- CSS -->
<style>
    /* Navbar */
    .navbar {
        background: linear-gradient(135deg, #2c3e50, #3498db);
        padding: 1rem 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .navbar-brand { font-size: 1.8rem; color: #ffffff !important; letter-spacing: 2px; transition: color 0.3s ease; }
    .navbar-brand:hover { color: #ecf0f1 !important; }
    .nav-link { color: #ffffff !important; font-size: 1rem; padding: 0.75rem 1.5rem !important; border-radius: 25px; transition: all 0.3s ease; position: relative; }
    .nav-link:hover, .nav-link:focus { background-color: rgba(255, 255, 255, 0.1); color: #ecf0f1 !important; }
    .nav-link i { margin-right: 6px; }
    .user-role { font-size: 0.7rem; color: #ecf0f1; position: absolute; top: 5px; right: 10px; background: rgba(0, 0, 0, 0.3); padding: 2px 6px; border-radius: 10px; }
    .dropdown-menu { background-color: #ffffff; border: none; border-radius: 10px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); margin-top: 5px; }
    .dropdown-item { padding: 0.5rem 1.5rem; color: #2c3e50; transition: all 0.3s ease; }
    .dropdown-item:hover { background-color: #3498db; color: #ffffff; }
    .dropdown-menu-end { right: 0; left: auto; }
    .navbar-toggler { border: none; }
    .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.9)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }

    /* Danh sách sản phẩm */
    .container { max-width: 1320px; }
    .display-4 { font-size: 2.5rem; letter-spacing: 1px; }
    .product-card { border-radius: 15px; transition: transform 0.3s ease, box-shadow 0.3s ease; background: #fff; }
    .product-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1); }
    .product-img-wrapper { position: relative; overflow: hidden; }
    .product-card img { height: 220px; object-fit: cover; transition: transform 0.3s ease; }
    .product-card:hover img { transform: scale(1.05); }
    .product-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.3); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; }
    .product-card:hover .product-overlay { opacity: 1; }
    .card-body { padding: 20px; }
    .card-title { font-size: 1.1rem; line-height: 1.4; height: 3.2rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .text-primary { color: #3498db !important; }
    .btn-sm { padding: 6px 12px; }
    .btn-primary { background: #3498db; border: none; transition: background 0.3s ease; }
    .btn-primary:hover { background: #2980b9; }
    .btn-outline-light { border-color: #fff; color: #fff; }
    .btn-outline-light:hover { background: #fff; color: #2c3e50; }
    .form-select, .form-control { padding: 10px; font-size: 0.95rem; }
    .rounded-pill { border-radius: 50rem !important; }
    .shadow-sm { box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important; }

    /* Responsive */
    @media (max-width: 768px) {
        .navbar-brand { font-size: 1.4rem; }
        .nav-link { padding: 0.5rem 1rem !important; font-size: 0.9rem; }
        .dropdown-menu { box-shadow: none; }
        .product-card img { height: 180px; }
        .card-title { font-size: 1rem; height: 2.8rem; }
        .btn-sm { padding: 5px 10px; }
        .user-role { font-size: 0.6rem; top: 2px; right: 5px; }
    }
</style>

<!-- JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const locationOptions = document.querySelectorAll(".location-option");
        const selectedLocation = document.getElementById("selectedLocation");
        locationOptions.forEach(option => {
            option.addEventListener("click", function (e) {
                e.preventDefault();
                selectedLocation.textContent = this.textContent;
            });
        });
    });
</script>

<?php include 'app/views/share/footer.php'; ?>