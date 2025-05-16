<?php
// seller_dashboard.php

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'ecommerce';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $shop = $_POST['shop'];
    $sql = "INSERT INTO sellers (name, email, shop) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $shop);
    $stmt->execute();
    $stmt->close();
    header("Location: seller_dashboard.php");
    exit;
}

// Handle Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $shop = $_POST['shop'];
    $sql = "UPDATE sellers SET name=?, email=?, shop=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $shop, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: seller_dashboard.php");
    exit;
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM sellers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: seller_dashboard.php");
    exit;
}

// Fetch sellers
$sellers = [];
$result = $conn->query("SELECT * FROM sellers");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $sellers[] = $row;
    }
}

// Fetch seller for edit
$edit_seller = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM sellers WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_seller = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Dashboard</title>
    <style>
        table { border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #eee; }
        form { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Seller Dashboard</h2>

    <!-- Add/Edit Seller Form -->
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $edit_seller['id'] ?? ''; ?>">
        <input type="text" name="name" placeholder="Name" required value="<?php echo $edit_seller['name'] ?? ''; ?>">
        <input type="email" name="email" placeholder="Email" required value="<?php echo $edit_seller['email'] ?? ''; ?>">
        <input type="text" name="shop" placeholder="Shop Name" required value="<?php echo $edit_seller['shop'] ?? ''; ?>">
        <?php if ($edit_seller): ?>
            <button type="submit" name="update">Update Seller</button>
            <a href="seller_dashboard.php">Cancel</a>
        <?php else: ?>
            <button type="submit" name="add">Add Seller</button>
        <?php endif; ?>
    </form>

    <!-- Sellers Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Shop</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($sellers as $seller): ?>
        <tr>
            <td><?php echo htmlspecialchars($seller['id']); ?></td>
            <td><?php echo htmlspecialchars($seller['name']); ?></td>
            <td><?php echo htmlspecialchars($seller['email']); ?></td>
            <td><?php echo htmlspecialchars($seller['shop']); ?></td>
            <td>
                <a href="?edit=<?php echo $seller['id']; ?>">Edit</a>
                <a href="?delete=<?php echo $seller['id']; ?>" onclick="return confirm('Delete this seller?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>