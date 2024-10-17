<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h1 class="text-center mb-4">Admin Dashboard</h1>
        <?php
        $activeTab = isset($_GET['active_tab']) ? $_GET['active_tab'] : 'users'; 
        ?>

        <!-- Tabs for different records -->
        <ul class="nav nav-pills mb-3  p-2 rounded" id="pills-tab" role="tablist">
            <li class="nav-item " role="presentation">
                <button class="nav-link  text-white bg-dark border border-light <?php echo $activeTab == 'users' ? 'active' : ''; ?>" id="pills-users-tab" data-bs-toggle="pill" data-bs-target="#pills-users" type="button" role="tab" aria-controls="pills-users" 
                aria-selected="<?php echo $activeTab == 'users' ? 'true' : 'false'; ?>">
                Users</button>
            </li>
            <li class="nav-item mx-3" role="presentation">
                <button class="nav-link  text-white bg-dark border border-light <?php echo $activeTab == 'orders' ? 'active' : ''; ?>" id="pills-orders-tab" data-bs-toggle="pill" data-bs-target="#pills-orders" type="button" role="tab" aria-controls="pills-orders"                 
                aria-selected="<?php echo $activeTab == 'orders' ? 'true' : 'false'; ?>">
                Orders</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $activeTab == 'items' ? 'active' : ''; ?> text-white bg-dark border border-light" id="pills-items-tab" data-bs-toggle="pill" data-bs-target="#pills-items" type="button" role="tab" aria-controls="pills-items"                 
                aria-selected="<?php echo $activeTab == 'items' ? 'true' : 'false'; ?>">
                Items</button>
            </li>
        </ul>


        <div class="tab-content" id="pills-tabContent">
            <!-- User Table Section -->
            <div class="tab-pane fade show 
            <?php echo $activeTab == 'users' ? 'show active' : ''; ?>" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Users</h2>
                    <button class="btn btn-dark" onclick="openForm('user')">Add User</button>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                        <tbody id="userTable">                           
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
                            $query="SELECT * FROM `users`";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result as $row){
                                echo "<tr>";
                                echo "<td>". $row['id']. "</td>";
                                echo "<td>". $row['name']. "</td>";
                                echo "<td>". $row['mobile']. "</td>";
                                echo "<td>". $row['email']. "</td>";
                                echo "<td>". $row['adress']. "</td>";
                                echo "<td>
                                <a href='./edit.php?type=user&id={$row['id']}' class='btn btn-dark'>Edit</a>
                                 <a href='./delete.php?type=user&id={$row['id']}' class='btn btn-danger'>Delete</a>
                                 </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </thead>
                   
                </table>
            </div>

            <!-- Order Table Section -->
            <div class="tab-pane fade 
            <?php echo $activeTab == 'orders' ? 'show active' : ''; ?>" id="pills-orders" role="tabpanel" aria-labelledby="pills-orders-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Orders</h2>
                   
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Item ID</th>
                        </tr>
                    </thead>
                    <tbody id="orderTable">
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

                            // Corrected SQL query
                            $query = "SELECT orders.order_id, users.name AS customer_name, item.item_name AS product_name FROM orders JOIN users ON orders.user_id = users.id JOIN item ON orders.item_id = item.item_id";

                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['order_id'] . "</td>"; 
                                echo "<td>" . $row['customer_name'] . "</td>";
                                echo "<td>" . $row['product_name'] . "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>

                </table>
            </div>

            <!-- Item Table Section -->
            <div class="tab-pane fade 
            <?php echo $activeTab == 'items' ? 'show active' : ''; ?>" id="pills-items" role="tabpanel" aria-labelledby="pills-items-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Items</h2>
                    <button class="btn btn-dark" onclick="openForm('item')">Add Item</button>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Item ID</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody id="itemTable">
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
                            $query="SELECT * FROM `item`";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['item_id'] . "</td>";
                                echo "<td>" . $row['item_name'] . "</td>";
                                echo "<td><img src='" . $row['item_image_url'] . "' alt='Item Image' style='width: 100px; height: auto;'/></td>";
                                echo "<td>" . $row['item_price'] ."$"."</td>";
                                echo "<td>
                                <a href='./edit.php?type=item&id={$row['item_id']}' class='btn btn-dark'>Edit</a> 
                                <button class='btn btn-danger'>Delete</button></td>";
                                echo "</tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add or Update Form -->
        <div id="formContainer" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formTitle">Add Record</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                            <div id="dynamicFields"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    

    
    <script>
function openForm(type) {

    const formTitle = document.getElementById('formTitle');
    formTitle.textContent = `Add ${type.charAt(0).toUpperCase() + type.slice(1)}`;
    const dynamicFields = document.getElementById('dynamicFields');
    
    console.log(dynamicFields);

    dynamicFields.innerHTML = '';  

    if (type === 'user') {
        dynamicFields.innerHTML = `
            <form method="POST" action="add_user.php">
                <div class="mb-3">
                    <label for="userName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="userName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="userMobile" class="form-label">Mobile</label>
                    <input type="text" class="form-control" id="userMobile" name="mobile" required>
                </div>
                <div class="mb-3">
                    <label for="userEmail" class="form-label">Email</label>
                    <input type="email" class="form-control" id="userEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="userAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="userAddress" name="address" required>
                </div>
                <button type="submit" name="addUser" class="btn btn-dark">Save User</button>
            </form>
        `;

        console.log(dynamicFields.innerHTML);

    }  else if (type === 'item') {
        dynamicFields.innerHTML = `
            <form method="post" action="add_item.php">
                <div class="mb-3">
                    <label for="itemDescription" class="form-label">Name</label>
                    <input type="text" class="form-control" id="itemDescription" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="itemImage" class="form-label">Image URL</label>
                    <input type="text" class="form-control" id="itemImage" name="image_url" required>
                </div>
                <div class="mb-3">
                    <label for="itemTotalNumber" class="form-label">Price</label>
                    <input type="number" class="form-control" id="itemTotalNumber" name="price" required>
                </div>
                <button type="submit" name="addItem" class="btn btn-dark">Save Item</button>
            </form>
        `;
    }

    new bootstrap.Modal(document.getElementById('formContainer')).show();
}
   
    </script>
</body>
</html>
