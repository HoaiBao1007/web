<?php include 'app/views/share/header.php'; ?>

<div class="container py-5">
    <div class="card shadow-lg p-4 mx-auto" style="max-width: 600px; border-radius: 15px;">
        <h2 class="text-center text-primary mb-4">✨ Thêm Sản Phẩm Mới ✨</h2>

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
                <label for="name" class="form-label fw-bold"> Tên sản phẩm</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-bold"> Mô tả</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Nhập mô tả sản phẩm" required></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label fw-bold"> Giá (VND)</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" placeholder="Nhập giá tiền" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label fw-bold"> Danh mục</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>">
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
    <label for="image" class="form-label fw-bold"> Hình ảnh</label>
    <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
    <div class="mt-2">
        <img id="imagePreview" src="#" alt="Xem trước ảnh" class="d-none" style="max-width: 150px; border-radius: 5px;">
    </div>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var preview = document.getElementById('imagePreview');
            preview.src = reader.result;
            preview.classList.remove('d-none'); // Hiển thị ảnh
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>


            <div class="text-center">
                <button type="submit" class="btn btn-primary w-100 py-2"> Thêm sản phẩm</button>
                <a href="/product" class="btn btn-secondary mt-2 w-100"> Quay lại</a>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
    }
    .card {
        background: white;
        border: none;
    }
</style>

<?php include 'app/views/share/footer.php'; ?>