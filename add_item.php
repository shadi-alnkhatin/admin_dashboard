<?php
$dbName = "admin_db";
$userName = "root";
$server = "localhost";
$password = "";

try {
    $conn = new PDO("mysql:host=$server;dbname=$dbName", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addItem'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    if (!empty($name) && !empty($price) && !empty($image_url) ) {
        try {
            $sql = $conn->prepare("INSERT INTO item (item_name, item_price, item_image_url) VALUES (:name, :price, :image_url)");

            $sql->bindParam(":name", $name);
            $sql->bindParam(":price", $price);
            $sql->bindParam(":image_url", $image_url);
           

            if ($sql->execute()) {
                header('Location: index.php?active_tab=items');
                exit(); 
            } else {
                echo "Error: Unable to create new user record.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: All fields are required.";
    }
}
?>
