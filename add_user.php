<?php
$dbName = "admin_db";
$userName = "root";
$server = "localhost";
$password = "";
echo"HII";
try {
    $conn = new PDO("mysql:host=$server;dbname=$dbName", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $hello ) {
    die("Connection failed: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addUser'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    if (!empty($name) && !empty($email) && !empty($mobile) && !empty($address)) {
        try {
            $sql = $conn->prepare("INSERT INTO users (name, email, mobile, adress) VALUES (:name, :email, :mobile, :address)");

            $sql->bindParam(":name", $name);
            $sql->bindParam(":email", $email);
            $sql->bindParam(":mobile", $mobile);
            $sql->bindParam(":address", $address);

            if ($sql->execute()) {
                header('Location: index.php');
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
