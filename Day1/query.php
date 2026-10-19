<?php

$host = 'localhost';
$dbname = 'test_db1';
$username = 'root';
$password = '';

try {
  
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h3>1. Connection: Connected successfully!</h3><hr>";

    // ---------------------------------------------------------
    // 2. (Create - Insert)
    // ---------------------------------------------------------
    $sql_insert = "INSERT INTO users (name, email) VALUES (:name, :email)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([
        ':name' => 'John Doe',
        ':email' => 'john@example.com'
    ]);
    echo "<h3>2. Create: User inserted successfully.</h3><hr>";

    // ---------------------------------------------------------
    // 3. (Update)
    // ---------------------------------------------------------
    $sql_update = "UPDATE users SET email = :email WHERE name = :name";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([
        ':email' => 'newemail@example.com',
        ':name' => 'John Doe'
    ]);
    echo "<h3>3. Update: User updated successfully.</h3><hr>";

    // ---------------------------------------------------------
    // 4. (Read - Select)
    // ---------------------------------------------------------
    echo "<h3>4. Read: Displaying Users from Database:</h3>";
    $sql_select = "SELECT * FROM users";
    $stmt_select = $pdo->query($sql_select);
    $users = $stmt_select->fetchAll();

    foreach ($users as $user) {
        echo "ID: " . $user['id'] . " | Name: " . $user['name'] . " | Email: " . $user['email'] . "<br>";
    }
    echo "<hr>";

    // ---------------------------------------------------------
    // 5. (Delete) 
    // ---------------------------------------------------------
   
    $sql_delete = "DELETE FROM users WHERE name = :name";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute([':name' => 'John Doe']);
    echo "<h3>5. Delete: User deleted successfully.</h3><hr>";
    

} catch (PDOException $e) {
   
    echo "Connection or Query Failed: " . $e->getMessage();
}
?>