<?php
require_once 'app/config/database.php';
require_once 'app/models/AccountModel.php';
require_once 'app/helpers/SessionHelper.php';

class AccountController
{
    private $accountModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    // Hiển thị form đăng nhập
    public function login()
    {
        if (SessionHelper::isLoggedIn()) {
            header('Location: /Product');
            exit;
        }
        include 'app/views/account/login.php';
    }

    // Xử lý đăng nhập
    public function processLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->accountModel->login($username, $password);
            if ($user) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['role'] = $user->role; // Lưu role thay vì is_admin
                header('Location: /Product');
                exit;
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                include 'app/views/account/login.php';
            }
        } else {
            $this->login();
        }
    }

    // Hiển thị form đăng ký
    public function register()
    {
        if (SessionHelper::isLoggedIn()) {
            header('Location: /Product');
            exit;
        }
        include 'app/views/account/register.php';
    }

    // Xử lý đăng ký
    public function processRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirmpassword'] ?? '';

            if ($password !== $confirm_password) {
                $error = "Mật khẩu xác nhận không khớp.";
                include 'app/views/account/register.php';
                return;
            }

            $result = $this->accountModel->register($username, $fullname, $password);
            if ($result === true) {
                $success = "Đăng ký thành công! Vui lòng đăng nhập.";
                include 'app/views/account/login.php';
            } else {
                $error = $result;
                include 'app/views/account/register.php';
            }
        } else {
            $this->register();
        }
    }

    // Đăng xuất
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /Account/login');
        exit;
    }
}
?>