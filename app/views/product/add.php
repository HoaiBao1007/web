<?php include 'app/views/share/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Mới</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
        }
        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: none;
        }
        h2 {
            font-size: 2rem;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .form-label {
            color: #2c3e50;
            font-weight: 600;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        .btn-primary {
            background-color: #3498db;
            border: none;
            border-radius: 50rem;
            padding: 12px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 50rem;
            padding: 12px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .alert-danger {
            border-radius: 10px;
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
        }
        .img-preview {
            border-radius: 10px;
            max-width: 150px;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: none; /* Ẩn mặc định */
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card">
            <h2><i class="fas fa-plus-circle me-2"></i> Thêm Sản Phẩm Mới</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                        </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Nhập mô tả sản phẩm" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Giá (VND)</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" placeholder="Nhập giá tiền" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <option value="" disabled selected>Chọn danh mục</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>">
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh</label>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <img id="imagePreview" src="#" alt="Xem trước ảnh" class="img-preview">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100 mb-2"><i class="fas fa-save me-2"></i> Thêm sản phẩm</button>
                    <a href="/product" class="btn btn-secondary w-100"><i class="fas fa-arrow-left me-2"></i> Quay lại</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var preview = document.getElementById('imagePreview');
                preview.src = reader.result;
                preview.style.display = 'block'; // Hiển thị ảnh khi có file
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function validateForm() {
            let name = document.getElementById('name').value.trim();
            let price = document.getElementById('price').value;
            let errors = [];

            if (name.length < 10 || name.length > 100) {
                errors.push('Tên sản phẩm phải có từ 10 đến 100 ký tự.');
            }
            if (price <= 0 || isNaN(price)) {
                errors.push('Giá phải là một số dương lớn hơn 0.');
            }

            if (errors.length > 0) {
                alert(errors.join('\n'));
                return false;
            }
            return true;
        }
    </script>
</body>
</html>

<?php include 'app/views/share/footer.php'; ?>