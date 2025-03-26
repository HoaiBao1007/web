<?php include 'app/views/share/header.php'; ?>

<!-- Thanh Navbar (Hợp nhất) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-custom shadow-sm">
    <div class="container">
        <!-- Logo/Brand -->
        <a class="navbar-brand text-white" href="#">HYPER BUY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Các mục bên trái -->
            <ul class="navbar-nav me-auto">
                <!-- Dropdown Quản lý (cho admin) -->
                <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="managementDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cogs"></i> Quản lý
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Quản lý sản phẩm</a></li>
                            <li><a class="dropdown-item" href="#">Danh sách sản phẩm</a></li>
                            <li><a class="dropdown-item" href="/Product/add">Thêm sản phẩm</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- Dropdown Danh mục -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-list"></i> Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($categories as $category): ?>
                            <li><a class="dropdown-item" href="#"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                
            <!-- Các mục bên phải -->
           
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"><i class="fas fa-truck"></i> Tra cứu đơn hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="/Product/cart"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a>
                </li>
                <!-- Dropdown Tài khoản -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user"></i> 
        <?php echo SessionHelper::isLoggedIn() ? htmlspecialchars($_SESSION['username']) : 'Tài khoản'; ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
        <?php if (SessionHelper::isLoggedIn()): ?>
            <li><a class="dropdown-item" href="/Account/login"><i class="fas fa-sign-in-alt"></i>Đăng Nhập</a></li>
            <li><a class="dropdown-item" href="/Account/logout"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a></li>
        <?php else: ?>
            <li><a class="dropdown-item" href="/Account/login"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</a></li>
            <li><a class="dropdown-item" href="/Account/register"><i class="fas fa-user-plus"></i> Đăng Ký</a></li>
        <?php endif; ?>
    </ul>
</li>
            </ul>
        </div>
    </div>
</nav>

<!-- Danh sách sản phẩm -->
<div class="container my-5">
    <h1 class="text-center mb-4">Danh sách sản phẩm</h1>

    <!-- Form tìm kiếm -->
    <form method="POST" action="/Product/search" class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" name="keyword" class="form-control" placeholder="Nhập tên sản phẩm hoặc mô tả">
            </div>
        </div>
        <div class="col-md-4">
            <select name="category_id" class="form-select">
                <option value="">Tất cả danh mục</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>">
                        <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
        </div>
    </form>

    <?php if (SessionHelper::isAdmin()): ?>
        <a href="/Product/add" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Thêm sản phẩm mới</a>
    <?php endif; ?>

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php if (empty($products)): ?>
            <p class="text-center">Không tìm thấy sản phẩm nào.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col">
                    <div class="card shadow-sm product-card h-100">
                        <img src="/<?php echo $product->image ? htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8') : 'images/default-product.jpg'; ?>" 
                            alt="Product Image" class="card-img-top">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title flex-grow-1">
                                <a href="/Product/show/<?php echo $product->id; ?>" class="text-dark text-decoration-none">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h6>
                            <p class="text-muted small"> <strong><?php echo number_format($product->price, 0, ',', '.'); ?> VND</strong></p>
                            <p class="text-muted small"> <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></p>
                            <div class="d-flex justify-content-between">
                                <?php if (SessionHelper::isAdmin()): ?>
                                    <a href="/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning btn-sm">✏️</a>
                                    <a href="/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">🗑️</a>
                                <?php endif; ?>
                                <a href="/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary btn-sm">🛒</a>
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
        padding: 15px 0;
        background: linear-gradient(90deg, #dc3545, #c82333);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
        letter-spacing: 1px;
        color: #fff !important;
    }
    .nav-link {
        font-size: 1rem;
        padding: 10px 20px !important;
        color: #fff !important;
        transition: all 0.3s ease;
    }
    .nav-link:hover, .nav-link:focus {
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 5px;
    }
    .nav-link i {
        margin-right: 8px;
    }
    .dropdown-menu {
        border: none;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        background-color: #fff;
    }
    .dropdown-item {
        padding: 10px 20px;
        color: #333;
        transition: background-color 0.3s ease;
    }
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    .dropdown-menu-end {
        right: 0;
        left: auto;
    }

    /* Danh sách sản phẩm */
    .product-card {
        border-radius: 10px;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
        overflow: hidden;
        padding: 15px;
    }
    .product-card img {
        height: 180px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .product-card:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .row {
        row-gap: 20px;
    }
    .input-group-text {
        background-color: #f8f9fa;
    }
    .btn-success {
        padding: 8px 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .navbar-brand {
            font-size: 1.2rem;
        }
        .nav-link {
            padding: 8px 15px !important;
            font-size: 0.9rem;
        }
        .dropdown-menu {
            box-shadow: none;
        }
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