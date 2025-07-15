<?php
// Load environment variables from .env file
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// Database connection details from environment variables
$db_host = $_ENV['MYSQL_HOST'] ?? 'db'; // 'db' is the service name in docker-compose
$db_user = $_ENV['MYSQL_USER'] ?? 'user';
$db_pass = $_ENV['MYSQL_PASSWORD'] ?? 'password';
$db_name = $_ENV['MYSQL_DATABASE'] ?? 'mydatabase';

// Redis connection details from environment variables
$redis_host = $_ENV['REDIS_HOST'] ?? 'cache'; // 'cache' is the service name in docker-compose
$redis_port = $_ENV['REDIS_PORT'] ?? 6379;

echo "<h1>Multi-Service Application Status</h1>";

// --- MySQL Database Connection ---
echo "<h2>MySQL Database Status:</h2>";
try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "<p style='color: green;'>Successfully connected to MySQL database!</p>";
    
    // Create table if not exists
    $sql_create_table = "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        message VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    if ($conn->query($sql_create_table) === TRUE) {
        echo "<p>Table 'messages' checked/created successfully.</p>";
    } else {
        echo "<p style='color: red;'>Error creating table: " . $conn->error . "</p>";
    }

    // Insert a message if table is empty (simple demo logic)
    $result = $conn->query("SELECT COUNT(*) FROM messages");
    $row = $result->fetch_row();
    if ($row[0] == 0) {
        $sql_insert = "INSERT INTO messages (message) VALUES ('Hello from Docker PHP App!')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "<p>Initial message inserted into database.</p>";
        } else {
            echo "<p style='color: red;'>Error inserting message: " . $conn->error . "</p>";
        }
    }

    // Fetch and display messages
    $sql_select = "SELECT id, message, created_at FROM messages ORDER BY created_at DESC LIMIT 5";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        echo "<h3>Recent Messages from Database:</h3>";
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li>ID: " . $row["id"]. " - Message: " . $row["message"]. " (Created: " . $row["created_at"]. ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No messages found in the database.</p>";
    }

    $conn->close();
} catch (Exception $e) {
    echo "<p style='color: red;'>MySQL Connection Error: " . $e->getMessage() . "</p>";
}

// --- Redis Cache Connection ---
echo "<h2>Redis Cache Status:</h2>";
try {
    $redis = new Redis();
    if ($redis->connect($redis_host, $redis_port)) {
        echo "<p style='color: green;'>Successfully connected to Redis cache!</p>";

        $redis->close();
    } else {
        echo "<p style='color: red;'>Could not connect to Redis at {$redis_host}:{$redis_port}</p>";
    }
} catch (RedisException $e) {
    echo "<p style='color: red;'>Redis Connection Error: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>An unexpected error occurred with Redis: " . $e->getMessage() . "</p>";
}

?>
