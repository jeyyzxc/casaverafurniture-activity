<?php
/**
 * Database Class
 * A reusable "Service" that handles all communication with MySQL.
 * Uses PDO (PHP Data Objects) for security against SQL Injection.
 */

class Database {
    // Properties to hold connection details
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset = 'utf8mb4';
    private $pdo; // The actual connection object

    /**
     * Constructor
     * Automatically connects to the database when you write: $db = new Database();
     */
    public function __construct() {
        // 1. Load credentials from config.php constants
        $this->host     = DB_HOST;
        $this->dbname   = DB_NAME;
        $this->username = DB_USER;
        $this->password = DB_PASS;

        // 2. Set up the DSN (Data Source Name)
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        // 3. Set options for security and error handling
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw errors (don't stay silent)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Return arrays like ['name' => 'Sofa']
            PDO::ATTR_EMULATE_PREPARES   => false,                // Use real prepared statements (Security)
        ];

        // 4. Attempt the connection
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            // If connection fails, stop everything and show why
            die("Database Connection Failed: " . $e->getMessage());
        }
    }

    /**
     * Helper: Run a Query
     * Used internally by fetchAll/fetchOne, or for UPDATE/INSERT/DELETE
     * * @param string $sql The SQL query (e.g., "SELECT * FROM users WHERE id = ?")
     * @param array $params The values to fill in the '?' placeholders
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    /**
     * Helper: Get Many Rows
     * Usage: $products = $db->fetchAll("SELECT * FROM products");
     */
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Helper: Get One Row
     * Usage: $user = $db->fetchOne("SELECT * FROM users WHERE id = ?", [1]);
     */
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch();
    }
    
    /**
     * Helper: Get Last Inserted ID
     * Useful when you just inserted an order and need its ID immediately
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Helper: Get Row Count
     * Useful for checking if a user already exists
     */
    public function rowCount($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt->rowCount();
    }
}
?>