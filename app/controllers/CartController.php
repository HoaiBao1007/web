<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CartController {
    public function index() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/Cart.php';
    }

    public function increase($id) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        }
        header("Location: /Cart");
        exit();
    }

    public function decrease($id) {
        if (isset($_SESSION['cart'][$id])) {
            if ($_SESSION['cart'][$id]['quantity'] > 1) {
                $_SESSION['cart'][$id]['quantity']--;
            } else {
                unset($_SESSION['cart'][$id]); // Nếu số lượng là 1, xóa sản phẩm khỏi giỏ hàng
            }
        }
        header("Location: /Cart");
        exit();
    }

    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: /Cart");
        exit();
    }
}
?>