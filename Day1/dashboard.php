<?php
session_start();
require_once 'function.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = connectDB(); 


$categories = getAllCategories($pdo);
$posts = getAllPosts($pdo);

$categories_count = count($categories);
$posts_count = count($posts);


$recent_posts = array_slice($posts, 0, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CMS Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="d-flex">
        <!-- Sidebar Navigation -->
        <div class="bg-dark text-white p-3 min-vh-100 shadow" style="width: 250px;">
            <h3 class="text-center py-3 fw-bold text-warning"><i class="fa-solid fa-blog me-2"></i>CMS Blog</h3>
            <hr class="border-secondary">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link active text-white fw-semibold"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="categories.php" class="nav-link text-white"><i class="fa-solid fa-list me-2"></i> Categories</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="posts.php" class="nav-link text-white"><i class="fa-solid fa-newspaper me-2"></i> Blog Posts</a>
                </li>
                <li class="nav-item mt-4">
                    <a href="logout.php" class="nav-link text-danger fw-semibold"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                </li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow-1 p-5">
            <!-- Welcome Banner -->
            <div class="p-4 mb-4 bg-white rounded shadow-sm border-start border-primary border-4">
                <h2 class="fw-bold text-dark">Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?>! 👋</h2>
                <p class="text-muted mb-0">Here is a quick overview and statistics of your blog activities today.</p>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(45deg, #0d6efd, #0dcaf0);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold text-white-50">Total Categories</h6>
                                <h2 class="display-5 fw-bold mb-0 text-white"><?php echo $categories_count; ?></h2>
                            </div>
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                                <i class="fa-solid fa-list fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="categories.php" class="text-white text-decoration-none small fw-semibold">View Categories <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-4 text-white" style="background: linear-gradient(45deg, #198754, #20c997);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold text-white-50">Total Blog Posts</h6>
                                <h2 class="display-5 fw-bold mb-0 text-white"><?php echo $posts_count; ?></h2>
                            </div>
                            <div class="bg-white bg-opacity-25 p-3 rounded-circle">
                                <i class="fa-solid fa-newspaper fa-2x text-white"></i>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="posts.php" class="text-white text-decoration-none small fw-semibold">View All Posts <i class="fa-solid fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts Section -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-clock-rotate-left me-2"></i>Recent Published Posts</h4>
                    <a href="posts.php" class="btn btn-outline-primary btn-sm">Manage All Posts</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mt-2">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_posts)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No posts found yet. Start by creating one!</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_posts as $post): ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo htmlspecialchars($post['title']); ?></td>
                                    <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($post['category_name']); ?></span></td>
                                    <td><?php echo htmlspecialchars($post['author_name']); ?></td>
                                    <td class="text-muted small"><?php echo $post['date']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>