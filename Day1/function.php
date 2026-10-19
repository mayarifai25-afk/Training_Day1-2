<?php
// ==========================================
// 1. Database Connection Function
// ==========================================
function connectDB() {
    $host = 'localhost';
    $dbname = 'test_db';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        die("DB Error: " . $e->getMessage());
    }
}

// ==========================================
// 2. Categories Functions
// ==========================================
function getAllCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
    return $stmt->fetchAll();
}

function insertCategory($pdo, $name) {
    $stmt = $pdo->prepare("INSERT INTO categories (category_name) VALUES (:name)");
    return $stmt->execute([':name' => $name]);
}

function deleteCategory($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}

// ==========================================
// 3. Blog Posts Functions (Practice Requirement)
// ==========================================


function getAllPosts($pdo) {
    $sql = "SELECT posts.*, categories.category_name, users.name AS author_name 
            FROM posts 
            JOIN categories ON posts.category_id = categories.id 
            JOIN users ON posts.user_id = users.id 
            ORDER BY posts.id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}


function insertPost($pdo, $title, $category_id, $user_id, $content, $date, $reading_time) {
    $sql = "INSERT INTO posts (title, category_id, user_id, content, date, reading_time) 
            VALUES (:title, :category_id, :user_id, :content, :date, :reading_time)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':title' => $title,
        ':category_id' => $category_id,
        ':user_id' => $user_id,
        ':content' => $content,
        ':date' => $date,
        ':reading_time' => $reading_time
    ]);
}


function getPostById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}


function updatePost($pdo, $id, $title, $category_id, $content, $reading_time) {
    $sql = "UPDATE posts SET title = :title, category_id = :category_id, content = :content, reading_time = :reading_time WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':id' => $id,
        ':title' => $title,
        ':category_id' => $category_id,
        ':content' => $content,
        ':reading_time' => $reading_time
    ]);
}

function deletePost($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
?>