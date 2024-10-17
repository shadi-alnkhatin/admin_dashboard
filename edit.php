<?php
$dbName = "admin_db";
$userName = "root";
$server = "localhost";
$password = "";
try {
    $conn = new PDO("mysql:host=$server;dbname=$dbName", $userName, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e ) {
    die("Connection failed: " . $e->getMessage());
}
$type = $_GET['type'] ?? null;
$id = $_GET['id'] ?? null;

// Ensure type and ID are provided
if (!$type || !$id) {
    die('Error: Missing entity type or ID.');
}


if ($type === 'user') {
    // Fetch user data from the database
    $query = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die('Error: User not found.');
    }
    ?>
    <h1>Edit User</h1>
    <form method="POST" action="edit.php?type=user&id=<?php echo $id; ?>">
        <label for="name">Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($data['name']); ?>" required>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>

        <label for="address">Address</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($data['adress']); ?>" required>

        <button type="submit" name="update_user">Update User</button>
    </form>
    <?php
} elseif ($type === 'item') {
    // Fetch item data from the database
    $query = $conn->prepare("SELECT * FROM item WHERE item_id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die('Error: Item not found.');
    }

    // Form for editing an item
    ?>
    <h1>Edit Item</h1>
    <form method="POST" action="edit.php?type=item&id=<?php echo $id; ?>">
        <label for="itemName">Name</label>
        <input type="text" name="itemName" value="<?php echo htmlspecialchars($data['item_name']); ?>" required>

        <label for="price">Price</label>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($data['item_price']); ?>" required>

        <button type="submit" name="update_item">Update Item</button>
    </form>
    <?php
} else {
    die('Error: Invalid entity type.');
}
?>

<?php
// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($type === 'user' && isset($_POST['update_user'])) {
        // Update user data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $updateQuery = $conn->prepare("UPDATE users SET name = :name, email = :email, adress = :address WHERE id = :id");
        $updateQuery->bindParam(':name', $name);
        $updateQuery->bindParam(':email', $email);
        $updateQuery->bindParam(':address', $address);
        $updateQuery->bindParam(':id', $id, PDO::PARAM_INT);

        if ($updateQuery->execute()) {
            header('Location: index.php?active_tab=users'); 
        } else {
            echo 'Error: Unable to update user.';
        }
    } elseif ($type === 'item' && isset($_POST['update_item'])) {
        // Update item data
        $itemName = $_POST['itemName'];
        $price = $_POST['price'];

        $updateQuery = $conn->prepare("UPDATE item SET item_name = :itemName, item_price = :price WHERE item_id = :id");
        $updateQuery->bindParam(':itemName', $itemName);
        $updateQuery->bindParam(':price', $price);
        $updateQuery->bindParam(':id', $id, PDO::PARAM_INT);

        if ($updateQuery->execute()) {
            header('Location: index.php?active_tab=items'); 
        } else {
            echo 'Error: Unable to update item.';
        }
    }
}
