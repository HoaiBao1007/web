<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProducts()
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category_name
                  FROM {$this->table_name} p
                  LEFT JOIN category c ON p.category_id = c.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function addProduct($name, $description, $price, $category_id, $image = null)
    {
        $query = "INSERT INTO {$this->table_name} (name, description, price, category_id, image)
                  VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);

        $name = trim(htmlspecialchars($name));
        $description = trim(htmlspecialchars($description));
        $price = floatval($price);
        $category_id = intval($category_id);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);

        return $stmt->execute();
    }

    public function updateProduct($id, $name, $description, $price, $category_id, $image = null)
    {
        if (!$this->getProductById($id)) {
            return false;
        }

        $query = "UPDATE {$this->table_name} 
                  SET name = :name, description = :description, price = :price, category_id = :category_id";
        if ($image !== null) {
            $query .= ", image = :image";
        }
        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $name = trim(htmlspecialchars($name));
        $description = trim(htmlspecialchars($description));
        $price = floatval($price);
        $category_id = intval($category_id);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        if ($image !== null) {
            $stmt->bindParam(':image', $image);
        }

        return $stmt->execute();
    }

    public function deleteProduct($id)
    {
        if (!$this->getProductById($id)) {
            return false;
        }

        $query = "DELETE FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Thêm phương thức tìm kiếm sản phẩm
    public function searchProducts($keyword, $category_id)
    {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category_name 
                  FROM {$this->table_name} p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE 1=1";

        if (!empty($keyword)) {
            $query .= " AND (p.name LIKE :keyword OR p.description LIKE :keyword)";
        }
        if (!empty($category_id)) {
            $query .= " AND p.category_id = :category_id";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($keyword)) {
            $keyword = "%" . trim(htmlspecialchars($keyword)) . "%";
            $stmt->bindParam(':keyword', $keyword);
        }
        if (!empty($category_id)) {
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>