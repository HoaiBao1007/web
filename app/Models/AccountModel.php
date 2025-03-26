<?php
class AccountModel
{
    private $conn;
    private $table_name = "account"; // Sửa thành "account"

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function login($username, $password)
    {
        $query = "SELECT id, username, password, role FROM {$this->table_name} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public function register($username, $fullname, $password)
    {
        // Kiểm tra xem username đã tồn tại chưa
        $query = "SELECT id FROM {$this->table_name} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->fetch(PDO::FETCH_OBJ)) {
            return "Tên đăng nhập đã tồn tại.";
        }

        // Thêm người dùng mới
        $query = "INSERT INTO {$this->table_name} (username, fullname, password, role) VALUES (:username, :fullname, :password, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':fullname', $fullname);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $hashed_password);
        $role = 'user'; // Mặc định là user khi đăng ký
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }
}
?>