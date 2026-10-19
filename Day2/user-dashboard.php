<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CMS Dashboard</title>
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
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link active text-white"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="categories.php" class="nav-link text-white"><i class="fa-solid fa-list me-2"></i> Categories</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="posts.php" class="nav-link text-white"><i class="fa-solid fa-newspaper me-2"></i> Blog Posts</a>
                </li>
                <li class="nav-item mt-4">
                    <a href="logout.php" class="nav-link text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow-1 p-4 bg-light">
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h2>
            <p class="text-muted">Manage your blog categories and posts easily from this panel.</p>
            <hr>

            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <div class="card shadow border-0 p-3 bg-primary text-white">
                        <h4>Categories</h4>
                        <p>Add and manage your blog categories.</p>
                        <a href="categories.php" class="btn btn-light btn-sm w-50">Manage Categories</a>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card shadow border-0 p-3 bg-success text-white">
                        <h4>Blog Posts</h4>
                        <p>Create, update, and publish posts.</p>
                        <a href="posts.php" class="btn btn-light btn-sm w-50">Manage Posts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>