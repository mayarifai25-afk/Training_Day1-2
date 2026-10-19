<?php
session_start();
require_once 'function.php'; 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pdo = connectDB(); 
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_post'])) {
    $title = trim($_POST['title']);
    $category_id = $_POST['category_id'];
    $content = trim($_POST['content']);
    $reading_time = trim($_POST['reading_time']);
    $user_id = $_SESSION['user_id'];
    $date = date('Y-m-d');

    if (!empty($title) && !empty($category_id) && !empty($content)) {
        insertPost($pdo, $title, $category_id, $user_id, $content, $date, $reading_time);
        $message = "Post published successfully!";
    } else {
        $message = "Please fill in all required fields.";
    }
}


if (isset($_GET['delete'])) {
    $post_id = $_GET['delete'];
    deletePost($pdo, $post_id);
    header("Location: posts.php");
    exit();
}


$categories = getAllCategories($pdo);
$posts = getAllPosts($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Posts</title>
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
                <li class="nav-item mb-2"><a href="categories.php" class="nav-link text-white"><i class="fa-solid fa-list me-2"></i> Categories</a></li>
                <li class="nav-item mb-2"><a href="posts.php" class="nav-link active text-white"><i class="fa-solid fa-newspaper me-2"></i> Blog Posts</a></li>
                <li class="nav-item mt-4"><a href="logout.php" class="nav-link text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="flex-grow-1 p-4 bg-light">
            <h2>Manage Blog Posts</h2>
            <hr>

            <?php if (!empty($message)): ?>
                <div class="alert alert-success"><?php echo $message; ?></div>
            <?php endif; ?>

            <!-- Form Add Post -->
            <div class="card shadow p-4 mb-4">
                <h4>Create New Post</h4>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Post Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Reading Time (e.g., 4 mins)</label>
                            <input type="text" name="reading_time" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" rows="4" class="form-control" required></textarea>
                    </div>
                    <button type="submit" name="add_post" class="btn btn-success">Publish Post</button>
                </form>
            </div>

            <!-- Table Display Posts -->
            <div class="card shadow p-4">
                <h4>All Blog Posts</h4>
                <table class="table table-bordered table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Reading Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?php echo $post['id']; ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($post['category_name']); ?></span></td>
                            <td><?php echo htmlspecialchars($post['author_name']); ?></td>
                            <td><?php echo $post['date']; ?></td>
                            <td><?php echo htmlspecialchars($post['reading_time']); ?></td>
                            <td>
                                <a href="posts.php?delete=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
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