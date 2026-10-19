<?php
session_start();
require_once 'function.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = connectDB(); 
$message = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        insertCategory($pdo, $category_name);
        $message = "Category added successfully!";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    deleteCategory($pdo, $id);
    header("Location: categories.php");
    exit();
}


$categories = getAllCategories($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar Navigation -->
        <div class="bg-dark text-white p-3 min-vh-100" style="width: 250px;">
            <h4 class="text-center py-2">CMS Blog</h4>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-2"><a href="dashboard.php" class="nav-link text-white"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a></li>
                <li class="nav-item mb-2"><a href="categories.php" class="nav-link active text-white"><i class="fa-solid fa-list me-2"></i> Categories</a></li>
                <li class="nav-item mb-2"><a href="posts.php" class="nav-link text-white"><i class="fa-solid fa-newspaper me-2"></i> Blog Posts</a></li>
                <li class="nav-item mt-4"><a href="logout.php" class="nav-link text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow-1 p-4 bg-light">
            <h2>Manage Categories</h2>
            <hr>

            <?php if (!empty($message)): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <!-- Form Add Category -->
            <div class="card shadow p-4 mb-4" style="max-width: 500px;">
                <h4>Add New Category</h4>
                <form method="POST">
                    <div class="mb-3">
                        <input type="text" name="category_name" class="form-control" placeholder="Category Name" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary">Save Category</button>
                </form>
            </div>

            <!-- Table Display Categories -->
            <div class="card shadow p-4">
                <h4>All Categories</h4>
                <table class="table table-bordered table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td><?php echo $cat['id']; ?></td>
                            <td><?php echo htmlspecialchars($cat['category_name']); ?></td>
                            <td>
                                <a href="categories.php?delete=<?php echo $cat['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>
</html>