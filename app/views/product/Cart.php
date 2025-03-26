<?php include 'app/views/share/header.php'; ?>
<h1 class="text-primary">Giỏ hàng</h1>

<?php if (!empty($cart)): ?>
<ul class="list-group">
    <?php 
    $total = 0;
    foreach ($cart as $id => $item): 
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <h2 class="text-success"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <?php if ($item['image']): ?>
                <img src="/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image" style="max-width: 100px;">
            <?php endif; ?>
            <p class="text-dark"><strong>Giá: <?php echo number_format($item['price'], 0, ',', '.'); ?> VND</strong></p>
            <p class="text-dark">
                <strong>Số lượng:</strong> 
                <a href="/Cart/decrease/<?php echo $id; ?>" class="btn btn-sm btn-outline-secondary">➖</a>
                <span class="mx-2"><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></span>
                <a href="/Cart/increase/<?php echo $id; ?>" class="btn btn-sm btn-outline-secondary">➕</a>
            </p>
            <p class="text-dark"><strong>Tạm tính: <?php echo number_format($subtotal, 0, ',', '.'); ?> VND</strong></p>
        </div>
        <div>
            <a href="/Cart/remove/<?php echo $id; ?>" class="btn btn-danger">Xóa</a>
        </div>
    </li>
    <?php endforeach; ?>
</ul>

<h3 class="text-danger mt-3">Tổng tiền: <?php echo number_format($total, 0, ',', '.'); ?> VND</h3>

<a href="/Product" class="btn btn-secondary mt-2">Tiếp tục mua sắm</a>
<a href="/Product/checkout" class="btn btn-primary mt-2">Thanh Toán</a>

<?php else: ?>
<p class="alert alert-warning">Giỏ hàng của bạn đang trống.</p>
<a href="/Product" class="btn btn-secondary mt-2">Tiếp tục mua sắm</a>
<?php endif; ?>

<?php include 'app/views/share/footer.php'; ?>