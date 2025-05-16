<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "ecommerce";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding a new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO products (name, price, description) VALUES ('$name', $price, '$description')";
    if ($conn->query($sql) === TRUE) {
        $msg = "Product added successfully!";
    } else {
        $msg = "Error: " . $conn->error;
    }
}

// Fetch all products
$products = [];
$result = $conn->query("SELECT * FROM products");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id=$id");
    header("Location: addproduct.php");
    exit;
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description']);

    $conn->query("UPDATE products SET name='$name', price=$price, description='$description' WHERE id=$id");
    header("Location: addproduct.php");
    exit;
}

// Fetch product for editing
$edit_product = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM products WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $edit_product = $res->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product - CRUD</title>
</head>
<body>
    <h2><?php echo isset($edit_product) ? "Edit Product" : "Add New Product"; ?></h2>
    <?php if (isset($msg)) echo "<p>$msg</p>"; ?>
    <form method="post">
        <?php if ($edit_product): ?>
            <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
        <?php endif; ?>
        <label>Name:</label>
        <input type="text" name="name" required value="<?php echo $edit_product['name'] ?? ''; ?>"><br>
        <label>Price:</label>
        <input type="number" step="0.01" name="price" required value="<?php echo $edit_product['price'] ?? ''; ?>"><br>
        <label>Description:</label>
        <textarea name="description" required><?php echo $edit_product['description'] ?? ''; ?></textarea><br>
        <button type="submit" name="<?php echo $edit_product ? 'update_product' : 'add_product'; ?>">
            <?php echo $edit_product ? 'Update' : 'Add'; ?>
        </button>
    </form>

    <h2>Product List</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Description</th><th>Actions</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo htmlspecialchars($product['id']); ?></td>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo htmlspecialchars($product['price']); ?></td>
            <td><?php echo htmlspecialchars($product['description']); ?></td>
            <td>
                <a href="?edit=<?php echo $product['id']; ?>">Edit</a> |
                <a href="?delete=<?php echo $product['id']; ?>" onclick="return confirm('Delete this product?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>