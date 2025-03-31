<?php include 'app/views/share/header.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
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
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        h1 {
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
        .alert-danger {
            border-radius: 10px;
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
        }
        .error {
            font-size: 0.9em;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        .img-thumbnail {
            border-radius: 10px;
            max-width: 100px;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-edit me-2"></i> Sửa sản phẩm</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/product/update" enctype="multipart/form-data" onsubmit="return validateForm();">
            <input type="hidden" name="id" value="<?php echo $product->id; ?>">
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả:</label>
                <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Giá (VND):</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="category_id" class="form-label">Danh mục:</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="image" class="form-label">Ảnh sản phẩm:</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <input type="hidden" name="existing_image" value="<?php echo $product->image; ?>">
                <?php if (!empty($product->image)): ?>
                    <img src="/<?php echo $product->image; ?>" alt="Hình sản phẩm" class="img-thumbnail">
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Lưu thay đổi</button>
        </form>
        
        <a href="/product" class="back-link"><i class="fas fa-arrow-left me-1"></i> Quay lại danh sách sản phẩm</a>
    </div>
    
    <script>
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